<?php

namespace App\Http\Requests\Panel;

use App\Models\OrganizationUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class OrganizationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(OrganizationUser::ORGAN_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'fname' => ['required', 'string', 'min:2', 'max:150'],
            'lname' => ['required', 'string', 'min:2', 'max:150'],
            'national_id' => ['required', 'string', 'unique:organization_users,national_id', new ValidNationalCard()],
            'organization_name' => ['required', 'string', 'max:255'],
            'organization_level' => ['required', 'string', 'max:255'],
            'national_card' => ['required', 'image', 'max:2048'],
            'personnel_card' => ['required', 'image', 'max:2048'],
            'introduction_letter' => ['required', 'image', 'max:2048'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:500'],
            'postal' => ['required', 'string', 'regex:/^(?!(\d)\1{3})[13-9]{4}[1346-9][013-9]{5}$/'],
            'landline_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'phone_number' => ['required', 'string', new ValidPhoneNumber()],
            'status' => ['nullable', 'string', 'in:pending,edited,confirmed,rejected,deactivate'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'fname' => 'نام',
            'lname' => 'نام خانوادگی',
            'national_id' => 'کد ملی',
            'organization_name' => 'نام سازمان',
            'organization_level' => 'سمت سازمانی',
            'national_card' => 'تصویر کارت ملی',
            'personnel_card' => 'تصویر کارت پرسنلی',
            'introduction_letter' => 'تصویر معرفی نامه',
            'province' => 'استان',
            'city' => 'شهر',
            'address' => 'آدرس',
            'postal' => 'کد پستی',
            'landline_number' => 'تلفن ثابت',
            'phone_number' => 'تلفن همراه',
            'status' => 'وضعیت',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'fname.required' => 'نام الزامی است.',
            'fname.min' => 'نام باید حداقل :min کاراکتر باشد.',
            'fname.max' => 'نام نباید بیشتر از :max کاراکتر باشد.',
            'lname.required' => 'نام خانوادگی الزامی است.',
            'lname.min' => 'نام خانوادگی باید حداقل :min کاراکتر باشد.',
            'lname.max' => 'نام خانوادگی نباید بیشتر از :max کاراکتر باشد.',
            'national_id.unique' => 'این کد ملی قبلاً ثبت شده است.',
            'national_card.required' => 'تصویر کارت ملی الزامی است.',
            'national_card.image' => 'فایل کارت ملی باید تصویر باشد.',
            'national_card.max' => 'حجم فایل کارت ملی نباید بیشتر از 2 مگابایت باشد.',
            'personnel_card.required' => 'تصویر کارت پرسنلی الزامی است.',
            'personnel_card.image' => 'فایل کارت پرسنلی باید تصویر باشد.',
            'personnel_card.max' => 'حجم فایل کارت پرسنلی نباید بیشتر از 2 مگابایت باشد.',
            'introduction_letter.required' => 'تصویر معرفی نامه الزامی است.',
            'introduction_letter.image' => 'فایل معرفی نامه باید تصویر باشد.',
            'introduction_letter.max' => 'حجم فایل معرفی نامه نباید بیشتر از 2 مگابایت باشد.',
            'organization_name.required' => 'نام سازمان الزامی است.',
            'organization_level.required' => 'سمت سازمانی الزامی است.',
            'province.required' => 'انتخاب استان الزامی است.',
            'city.required' => 'انتخاب شهر الزامی است.',
            'address.required' => 'آدرس الزامی است.',
            'postal.required' => 'کد پستی الزامی است.',
            'postal.regex' => 'کد پستی معتبر نیست.',
            'phone_number.required' => 'تلفن همراه الزامی است.',
        ];
    }
}
