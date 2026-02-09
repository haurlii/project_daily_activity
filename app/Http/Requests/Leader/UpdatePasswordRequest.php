<?php

namespace App\Http\Requests\Leader;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password'      => 'required|alpha_num:ascii|current_password',
            'password'              => 'required|alpha_num:ascii|min:8|different:current_password',
            'password_confirmation' => 'required|alpha_num:ascii|min:8|same:password',
        ];
    }
    public function messages(): array
    {
        return [
            'current_password.required'         => 'Password tidak boleh kosong',
            'current_password.current_password' => 'Password lama tidak valid',
            'password.required'                 => 'Password tidak boleh kosong',
            'password.min'                      => 'Password minimal 8 karakter',
            'password.different'                => 'Password baru tidak boleh sama dengan password lama',
            'password_confirmation.required'    => 'Password konfirmasi tidak boleh kosong',
            'password_confirmation.min'         => 'Password konfirmasi minimal 8 karakter',
            'password_confirmation.same'        => 'Password konfirmasi harus sama dengan password baru',
        ];
    }
}
