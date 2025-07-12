<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class OrganizationSmsRequest extends FormRequest
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
            'national_id' => ['required', new ValidNationalCard()],
            'phone_number' => ['required', new ValidPhoneNumber()],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'national_id' => 'کد ملی',
            'phone_number' => 'شماره همراه',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'national_id.required' => 'کد ملی الزامی است.',
            'phone_number.required' => 'شماره همراه الزامی است.',
        ];
    }
}
