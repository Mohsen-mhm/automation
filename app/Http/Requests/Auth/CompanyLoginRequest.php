<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class CompanyLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'national_id' => ['required', 'string'],
            'phone_number' => ['required', new ValidPhoneNumber()],
            'code' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'national_id' => 'شناسه ملی',
            'phone_number' => 'شماره همراه',
            'code' => 'کد تایید',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'این فیلد باید حتما وارد شود.',
        ];
    }
}
