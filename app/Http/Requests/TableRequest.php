<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
        // Create bulk of tables
        if ($this->isBulk) {
            return [
                'prefix' => 'required',
                'bulkOfTable' => 'required|gt:0',
                'capacity' => 'nullable',
                'status' => 'nullable'
            ];
        }

        // Create one at a time
        return [
            'name' => 'required|unique:tables,name',
            'prefix' => 'required',
            'capacity' => 'required|gt:0',
            'status' => 'nullable'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'bulkOfTable' => (int)$this->bulkOfTable,
            'capacity' => (int)$this->capacity,
        ]);
    }

    public function messages()
    {
        return [
            'bulkOfTable.gt' => 'The no of table must be greater than 1.'
        ];
    }
}
