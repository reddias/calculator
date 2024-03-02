<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TravelExpensesRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => 'required|string|',
            'road_cost' => 'required|numeric',
            'food_cost' => 'required|numeric',
            'accommodation_cost' => 'required|numeric',
        ];

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function messages(): array
    {
        $messages = [];

        foreach ($this->rules() as $attribute => $rules) {
            foreach (explode('|', $rules) as $rule) {
                $messages["$attribute.$rule"] = __('validation.' . $rule, [
                    'attribute' => __('travel.' . $attribute),
                ]);
            }
        }

        return $messages;
    }

    /**
     * Custom validation error
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
