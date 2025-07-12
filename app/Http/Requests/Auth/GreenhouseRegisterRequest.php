<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;

class GreenhouseRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'licence_number' => ['required', 'string', 'min:4', 'unique:greenhouses,licence_number'],
            'substrate_type' => ['required', 'string'],
            'product_type' => ['required', 'string'],
            'meterage' => ['required', 'string'],
            'greenhouse_status' => ['required', 'string'],
            'operation_date' => ['nullable', 'string'],
            'construction_date' => ['nullable', 'string'],
            'owner_name' => ['required', 'string', 'min:2'],
            'owner_phone' => ['required', 'string', new ValidPhoneNumber()],
            'owner_national_id' => ['required', 'string', new ValidNationalCard()],
            'climate_system' => ['boolean'],
            'feeding_system' => ['boolean'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'location_link' => ['required', 'string', new ValidUrl(), 'regex:/^https?:\/\/maps\.app\.goo\.gl\/[\w\-]+$/'],
            'operation_licence' => ['required', 'image', 'max:2048'],
            'image' => ['required', 'image', 'max:2048'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            '*.required' => 'این فیلد باید حتما وارد شود.',
            'name.min' => 'نام گلخانه باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام گلخانه نباید بیشتر از :max کاراکتر باشد.',
            'licence_number.unique' => 'این شماره پروانه قبلاً ثبت شده است.',
            'owner_name.min' => 'نام مالک باید حداقل :min کاراکتر باشد.',
            'province_id.exists' => 'استان انتخاب شده معتبر نیست.',
            'city_id.exists' => 'شهر انتخاب شده معتبر نیست.',
            'location_link.regex' => 'فرمت لینک گوگل مپ صحیح نیست.',
            'operation_licence.image' => 'فایل پروانه بهره برداری باید تصویر باشد.',
            'operation_licence.max' => 'حجم فایل پروانه بهره برداری نباید بیشتر از 2 مگابایت باشد.',
            'image.image' => 'فایل تصویر گلخانه باید تصویر باشد.',
            'image.max' => 'حجم فایل تصویر گلخانه نباید بیشتر از 2 مگابایت باشد.',
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
            'operation_date' => 'تاریخ بهره برداری',
            'construction_date' => 'تاریخ احداث',
            'owner_name' => 'نام مالک',
            'owner_phone' => 'تلفن همراه مالک',
            'owner_national_id' => 'کد ملی مالک',
            'climate_system' => 'سامانه کنترل اقلیم',
            'feeding_system' => 'سامانه تغذیه و آبیاری',
            'province_id' => 'استان',
            'city_id' => 'شهر',
            'address' => 'آدرس',
            'postal' => 'کد پستی',
            'location_link' => 'لینک موقعیت',
            'operation_licence' => 'پروانه بهره برداری',
            'image' => 'تصویر گلخانه',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to boolean
        $this->merge([
            'climate_system' => $this->boolean('climate_system'),
            'feeding_system' => $this->boolean('feeding_system'),
        ]);

        // Convert province and city names to IDs if needed
        if ($this->has('province') && !$this->has('province_id')) {
            $province = \App\Models\Province::where('name', $this->province)->first();
            if ($province) {
                $this->merge(['province_id' => $province->id]);
            }
        }

        if ($this->has('city') && !$this->has('city_id')) {
            $city = \App\Models\City::where('name', $this->city)->first();
            if ($city) {
                $this->merge(['city_id' => $city->id]);
            }
        }
    }
}
