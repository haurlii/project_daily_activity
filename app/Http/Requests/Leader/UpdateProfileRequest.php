<?php

namespace App\Http\Requests\Leader;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === "Leader";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string',
            'username'  => 'required|string|unique:users,username,' . Auth::user()->id,
            'email'     => 'required|email:dns|unique:users,email,' . Auth::user()->id,
            'address'   => 'nullable|string',
            'contact'   => 'nullable|string|max:13',
            'division'  => 'required',
            'avatar_tmp'  => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'     => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique'   => 'Username sudah digunakan',
            'email.required'    => 'Email tidak boleh kosong',
            'email.unique'      => 'Email sudah ada',
            'contact.max'       => 'Nomer telepon maksimal 13 karakter',
            'division.required' => 'Divisi harus pilih salah satu',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->avatar_tmp && Storage::disk('public')->exists($this->avatar_tmp)) {
            Storage::disk('public')->delete($this->avatar_tmp);
        }

        throw new HttpResponseException(
            redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menyimpan data')
        );
    }
}
