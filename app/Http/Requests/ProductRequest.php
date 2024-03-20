<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'barcode' => 'nullable',
            'name' => 'required',
            'desc' => 'nullable',
            'image' => 'nullable|image',
            'price' => 'required|gt:0',
            'available' => 'nullable',
            'thumbnail' => 'nullable'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'barcode' => (string)$this->barcode,
            'desc' => (string)$this->desc,
            'available' => filter_var($this->available, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        ]);
    }
}
