<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Si no tienes control de roles, déjalo en true
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'count' => 'required|integer|min:0',
            'gender' => 'required|string',
            'due_date' => 'required|date',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ];

        // Si es método POST (crear), el archivo es obligatorio
        if ($this->isMethod('post')) {
            $rules['file'] = 'required|mimes:pdf,doc,docx|max:2048';
        }

        return $rules;
    }

}
