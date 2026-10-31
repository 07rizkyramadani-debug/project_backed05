<?php

namespace Modules\Books\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Books\Rules\ValidIsbn;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('isbn')) {
            $this->merge([
                'isbn' => strtoupper(preg_replace('/[\s-]+/', '', (string) $this->input('isbn'))),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'isbn' => [
                'required', 'string', new ValidIsbn(),
                Rule::unique('books', 'isbn')->ignore($this->route('book')),
            ],
            'publication_year' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'author_id' => ['required', 'exists:authors,id'],
        ];
    }

    public function messages(): array
    {
        return (new StoreBookRequest())->messages();
    }
}
