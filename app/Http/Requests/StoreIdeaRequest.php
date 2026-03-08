<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'reference' => 'nullable|string',
        ];
    }
}
