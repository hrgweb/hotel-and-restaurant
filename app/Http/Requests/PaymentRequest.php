<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'order_id' => 'required',
            'table_id' => 'required',
            'amount' => 'required',
            'total' => 'required',
            'change' => 'nullable',
            'payment_type' => 'nullable'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => (float)$this->amount,
            'total' => (float)$this->total,
            'change' => (float)$this->change,
        ]);
    }
}
