<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePeriodPaymentPayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payerId' => ['required', Rule::exists('payers', 'id')],
            'amount' => 'required|numeric|min:0|not_in:0'
        ];
    }
}
