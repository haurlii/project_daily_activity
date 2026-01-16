<?php

namespace App\Http\Requests\Leader;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'member_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date',

        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Harus pilih salah satu anggota',
            'title.required' => 'Judul tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter',
            'start_date.required' => 'Tanggal mulai tidak boleh kosong',
            'end_date.required' => 'Tanggal selesai tidak boleh kosong',
        ];
    }
}
