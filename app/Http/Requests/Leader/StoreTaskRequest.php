<?php

namespace App\Http\Requests\Leader;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'description' => 'nullable|string|max:1500',
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i|before_or_equal:end_time|different:end_time',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time|different:start_time',
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
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'start_date.before_or_equal' => 'Tanggal mulai tidak boleh lebih dari tanggal selesai.',
            'end_date.required' => 'Tanggal selesai tidak boleh kosong',
            'end_date.after_or_equal'   => 'Tanggal selesai tidak boleh kurang dari tanggal mulai.',
            'start_time.required' => 'Jam mulai tidak boleh kosong',
            'start_time.before_or_equal' => 'Jam mulai tidak boleh lebih dari jam selesai.',
            'start_time.different' => 'Jam mulai tidak boleh sama dengan jam selesai.',
            'end_time.required' => 'Jam selesai tidak boleh kosong',
            'end_time.after_or_equal' => 'Jam selesai tidak boleh kurang dari jam mulai.',
            'end_time.different' => 'Jam selesai tidak boleh sama dengan jam mulai.',
        ];
    }
}
