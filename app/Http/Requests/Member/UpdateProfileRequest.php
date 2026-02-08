<?php

namespace App\Http\Requests\Member;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === "Member";
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
}
