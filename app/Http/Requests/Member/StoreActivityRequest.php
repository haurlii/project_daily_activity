<?php

namespace App\Http\Requests\Member;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1500',
            'start_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul tidak boleh kosong',
            'description.required' => 'Detail aktivitas tidak boleh kosong',
            'description.max' => 'Detail aktivitas terlalu panjang',
            'start_date.required' => 'Tanggal pengerjaan tidak boleh kosong',
            'start_date.date' => 'Format tanggal tidak valid',
        ];
    }
}
