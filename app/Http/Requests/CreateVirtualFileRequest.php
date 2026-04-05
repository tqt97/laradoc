<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVirtualFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'size' => 'required|integer',
            'mime_type' => 'required|string',
            'uploader_name' => 'nullable|string|max:100',
        ];
    }
}
