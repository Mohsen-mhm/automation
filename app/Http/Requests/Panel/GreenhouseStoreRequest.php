<?php

namespace App\Http\Requests\Panel;

use App\Models\Greenhouse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;

class GreenhouseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(Greenhouse::GREENHOUSE_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'licence_number' => ['required', 'string', 'min:4', 'unique:greenhouses,licence_number'],
            'substrate_type' => ['required', 'string'],
            'product_type' => ['required', 'string'],
            'meterage' => ['required', 'string'],
            'greenhouse_status' => ['required', 'string'],
            'construction_date' => ['nullable', 'string'],
            'operation_date' => ['nullable', 'string'],
            'owner_name' => ['required', 'string', 'min:2'],
            'owner_phone' => ['required', 'string', new ValidPhoneNumber()],
            'owner_national_id' => ['required', 'string', new ValidNationalCard()],
            'climate_system' => ['required', 'boolean'],
            'feeding_system' => ['required', 'boolean'],
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'location_link' => ['required', 'string', 'url', 'regex:/^https?:\/\/maps\.app\.goo\.gl\/[\w\-]+$/'],
            'operation_licence' => ['required', 'image', 'max:2048'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'string', 'in:pending,edited,confirmed,rejected,deactivate'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'نام گلخانه',
            'licence_number' => 'شماره پروانه',
            'substrate_type' => 'نوع بستر',
            'product_type' => 'نوع محصول',
            'meterage' => 'متراژ',
            'greenhouse_status' => 'وضعیت گلخانه',
            'construction_date' => 'تاریخ احداث',
            'operation_date' => 'تاریخ بهره برداری',
            'owner_name' => 'نام مالک',
            'owner_phone' => 'تلفن مالک',
            'owner_national_id' => 'کد ملی مالک',
            'climate_system' => 'سامانه کنترل اقلیم',
            'feeding_system' => 'سامانه تغذیه و آبیاری',
            'province' => 'استان',
            'city' => 'شهر',
            'address' => 'آدرس',
            'postal' => 'کد پستی',
            'location_link' => 'لینک موقعیت',
            'operation_licence' => 'پروانه بهره برداری',
            'image' => 'تصویر گلخانه',
            'status' => 'وضعیت',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام گلخانه الزامی است.',
            'name.min' => 'نام گلخانه باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام گلخانه نباید بیشتر از :max کاراکتر باشد.',
            'licence_number.unique' => 'این شماره پروانه قبلاً ثبت شده است.',
            'location_link.regex' => 'فرمت لینک گوگل مپ صحیح نیست.',
            'operation_licence.required' => 'پروانه بهره برداری الزامی است.',
            'operation_licence.image' => 'فایل پروانه بهره برداری باید تصویر باشد.',
            'operation_licence.max' => 'حجم فایل پروانه بهره برداری نباید بیشتر از 2 مگابایت باشد.',
            'image.image' => 'فایل تصویر گلخانه باید تصویر باشد.',
        ];
    }
}
