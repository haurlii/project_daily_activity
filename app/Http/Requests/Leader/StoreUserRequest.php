<?php

namespace App\Http\Requests\Leader;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email:dns|unique:users,email',
            'address' => 'nullable|string',
            'contact' => 'nullable|string|max:13',
            'password' => 'required|alpha_num:ascii|min:8',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique' => 'Username sudah ada',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah ada',
            'contact.max' => 'Nomer telepon maksimal 13 karakter',
            'password.required' => 'Kata sandi tidak boleh kosong',
            'password.min' => 'Kata sandi minimal 8 karakter',
        ];
    }
}
