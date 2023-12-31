<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayerAddCreditsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => 'nullable|numeric|min:0|not_in:0',
        ];
    }
}
