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
            'description' => 'required|string|max:1500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Aktivitas tidak boleh kosong',
            'description.required' => 'Detail aktivitas tidak boleh kosong',
            'description.max' => 'Detail aktivitas terlalu panjang',
        ];
    }
}
