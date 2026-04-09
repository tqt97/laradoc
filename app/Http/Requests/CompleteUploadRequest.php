<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_id' => 'required|exists:files,id',
            'temp_id' => 'required|string',
            'total_chunks' => 'required|integer',
        ];
    }
}
