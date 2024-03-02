<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PowerSupplyRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'power_rating' => "required|string",
            'cost_of_necessary_resources' => "required|numeric",
            'cost_of_battery_assembly_per_unit' => "required|numeric",
            'cost_of_manufacturing_jumpers' => "required|numeric",
            'cost_of_chief_installation' => "required|numeric",
            'days_required' => "required|numeric",
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [];

        foreach ($this->rules() as $attribute => $rules) {
            foreach (explode('|', $rules) as $rule) {
                $messages["$attribute.$rule"] = __('validation.' . $rule, [
                    'attribute' => __('power.' . $attribute),
                ]);
            }
        }

        return $messages;
    }

    /**
     * Custom validation error handling.
     *
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(response()
            ->json(
                [
                    'message' => __('error.form_validate'),
                    'errors' => $validator->errors(),
                ],
                422
            ));
    }
}
