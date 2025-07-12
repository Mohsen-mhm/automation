<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;

class CompanyRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'type' => ['required', 'string', 'max:100'],
            'national_id' => ['required', 'string', 'min:4', 'unique:companies,national_id'],
            'registration_number' => ['required', 'string', 'unique:companies,registration_number'],
            'registration_place' => ['required', 'string', 'max:100'],
            'registration_date' => ['required', 'string'],
            'climate_system' => ['nullable', 'boolean'],
            'feeding_system' => ['nullable', 'boolean'],
            'ceo_name' => ['required', 'string', 'max:100'],
            'ceo_phone' => ['required', 'string', new ValidPhoneNumber()],
            'ceo_national_id' => ['required', 'string', new ValidNationalCard()],
            'interface_name' => ['required', 'string', 'max:100'],
            'interface_phone' => ['required', 'string', new ValidPhoneNumber()],
            'company_logo' => ['required', 'image', 'max:2048'],
            'brand' => ['required', 'string', 'max:100'],
            'brand_logo' => ['required', 'image', 'max:2048'],
            'trademark_certificate' => ['required', 'image', 'max:2048'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:500'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['required', 'string', new ValidPhoneNumber()],
            'phone_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'location_link' => ['required', 'string'],
            'website' => ['required', 'string', 'url', 'max:200'],
            'email' => ['required', 'email', 'max:100'],
            'official_newspaper' => ['required', 'file', 'mimes:jpeg,png,svg,pdf', 'max:5120'],
            'operation_licence' => ['required', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام شرکت',
            'type' => 'نوع شرکت',
            'national_id' => 'شناسه ملی',
            'registration_number' => 'شماره ثبت',
            'registration_place' => 'محل ثبت',
            'registration_date' => 'تاریخ ثبت',
            'climate_system' => 'سامانه کنترل اقلیم',
            'feeding_system' => 'سامانه تغذیه و آبیاری',
            'ceo_name' => 'نام مدیرعامل',
            'ceo_phone' => 'تلفن مدیرعامل',
            'ceo_national_id' => 'کدملی مدیرعامل',
            'interface_name' => 'نام رابط',
            'interface_phone' => 'تلفن رابط',
            'company_logo' => 'لوگو شرکت',
            'brand' => 'علامت تجاری',
            'brand_logo' => 'لوگو علامت تجاری',
            'trademark_certificate' => 'گواهی ثبت علامت تجاری',
            'province_id' => 'استان',
            'city_id' => 'شهر',
            'address' => 'آدرس',
            'postal' => 'کد پستی',
            'landline_number' => 'تلفن ثابت',
            'phone_number' => 'تلفن همراه',
            'location_link' => 'لینک موقعیت',
            'website' => 'وب سایت',
            'email' => 'ایمیل',
            'official_newspaper' => 'روزنامه رسمی',
            'operation_licence' => 'پروانه بهره برداری',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام شرکت الزامی است.',
            'name.min' => 'نام شرکت باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام شرکت نباید بیشتر از :max کاراکتر باشد.',
            'national_id.unique' => 'این شناسه ملی قبلاً ثبت شده است.',
            'registration_number.unique' => 'این شماره ثبت قبلاً ثبت شده است.',
            'company_logo.required' => 'لوگو شرکت الزامی است.',
            'company_logo.image' => 'فایل لوگو شرکت باید تصویر باشد.',
            'company_logo.max' => 'حجم فایل لوگو شرکت نباید بیشتر از 2 مگابایت باشد.',
            'brand_logo.required' => 'لوگو علامت تجاری الزامی است.',
            'brand_logo.image' => 'فایل لوگو علامت تجاری باید تصویر باشد.',
            'trademark_certificate.required' => 'گواهی ثبت علامت تجاری الزامی است.',
            'province_id.required' => 'انتخاب استان الزامی است.',
            'province_id.exists' => 'استان انتخاب شده معتبر نیست.',
            'city_id.required' => 'انتخاب شهر الزامی است.',
            'city_id.exists' => 'شهر انتخاب شده معتبر نیست.',
            'location_link.regex' => 'فرمت لینک گوگل مپ صحیح نیست.',
            'official_newspaper.required' => 'روزنامه رسمی الزامی است.',
            'official_newspaper.mimes' => 'فرمت فایل روزنامه رسمی باید jpeg، png، svg یا pdf باشد.',
            'operation_licence.required' => 'پروانه بهره برداری الزامی است.',
            'operation_licence.image' => 'فایل پروانه بهره برداری باید تصویر باشد.',
        ];
    }
}
