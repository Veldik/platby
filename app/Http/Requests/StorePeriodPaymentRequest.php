<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePeriodPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'cronExpression' => 'required|string|valid_cron',
            'periodPayers.*.payerId' => ['required', Rule::exists('payers', 'id')],
            'periodPayers.*.amount' => 'required|numeric|min:0|not_in:0',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->addExtension('valid_cron', function($attribute, $value, $parameters, $validator) {
            try {
                \Cron\CronExpression::factory($value);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        $validator->addReplacer('valid_cron', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute is not a valid CRON expression.');
        });
    }
}
