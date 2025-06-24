<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or add logic to restrict access
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'copies' => 'required|integer|min:1',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }
}
