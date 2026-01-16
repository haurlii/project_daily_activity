<?php

namespace App\Http\Requests\Superadmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === "SuperAdmin";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:13',
            'role' => 'required',
            'division' => 'required',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'contact.max' => 'Nomer telepon maksimal 13 karakter',
            'role.required' => 'Harus memilih salah satu posisi',
            'division.required' => 'Harus memilih salah satu divisi',
        ];
    }
}
