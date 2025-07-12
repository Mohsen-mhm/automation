<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class GreenhouseLoginRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'licence_number' => ['required', 'string'],
            'phone_number' => ['required', new ValidPhoneNumber()],
            'code' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            '*.required' => 'این فیلد باید حتما وارد شود.',
            'phone_number.valid_phone_number' => 'شماره تلفن وارد شده معتبر نیست.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'licence_number' => 'شماره پروانه گلخانه',
            'phone_number' => 'شماره همراه',
            'code' => 'کد تایید',
        ];
    }
}
