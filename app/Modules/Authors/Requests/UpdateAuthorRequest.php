<?php

namespace Modules\Authors\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('authors', 'email')->ignore($this->route('author')),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return (new StoreAuthorRequest())->messages();
    }
}


