<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'sometimes|string|in:ordinary,moderator',
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
                    'attribute' => __('user.' . $attribute),
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
