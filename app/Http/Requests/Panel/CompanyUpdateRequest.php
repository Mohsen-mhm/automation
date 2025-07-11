<?php

namespace App\Http\Requests\Panel;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;

class CompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(Company::COMPANY_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'type' => ['required', 'string', 'max:100'],
            'national_id' => ['required', 'string', 'min:4', Rule::unique('companies', 'national_id')->ignore($company->id)],
            'registration_number' => ['required', 'string', Rule::unique('companies', 'registration_number')->ignore($company->id)],
            'registration_place' => ['required', 'string', 'max:100'],
            'registration_date' => ['required', 'string'],
            'climate_system' => ['required', 'boolean'],
            'feeding_system' => ['required', 'boolean'],
            'ceo_name' => ['required', 'string', 'max:100'],
            'ceo_phone' => ['required', 'string', new ValidPhoneNumber()],
            'ceo_national_id' => ['required', 'string', new ValidNationalCard()],
            'interface_name' => ['required', 'string', 'max:100'],
            'interface_phone' => ['required', 'string', new ValidPhoneNumber()],
            'company_logo' => ['nullable', 'image', 'max:2048'],
            'brand' => ['required', 'string', 'max:100'],
            'brand_logo' => ['nullable', 'image', 'max:2048'],
            'trademark_certificate' => ['nullable', 'image', 'max:2048'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:500'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['required', 'string', new ValidPhoneNumber()],
            'phone_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'location_link' => ['required', 'string', new ValidUrl(), 'regex:/^https?:\/\/maps\.app\.goo\.gl\/[\w\-]+$/'],
            'website' => ['required', 'string', 'url', 'max:200'],
            'email' => ['required', 'email', 'max:100'],
            'official_newspaper' => ['nullable', 'file', 'mimes:jpeg,png,svg,pdf', 'max:5120'],
            'operation_licence' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'string', 'in:pending,edited,confirmed,rejected,deactivate'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
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
            'status' => 'وضعیت',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام شرکت الزامی است.',
            'name.min' => 'نام شرکت باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام شرکت نباید بیشتر از :max کاراکتر باشد.',
            'national_id.unique' => 'این شناسه ملی قبلاً ثبت شده است.',
            'registration_number.unique' => 'این شماره ثبت قبلاً ثبت شده است.',
            'company_logo.image' => 'فایل لوگو شرکت باید تصویر باشد.',
            'company_logo.max' => 'حجم فایل لوگو شرکت نباید بیشتر از 2 مگابایت باشد.',
            'brand_logo.image' => 'فایل لوگو علامت تجاری باید تصویر باشد.',
            'trademark_certificate.image' => 'فایل گواهی ثبت علامت تجاری باید تصویر باشد.',
            'province_id.required' => 'انتخاب استان الزامی است.',
            'province_id.exists' => 'استان انتخاب شده معتبر نیست.',
            'city_id.required' => 'انتخاب شهر الزامی است.',
            'city_id.exists' => 'شهر انتخاب شده معتبر نیست.',
            'location_link.regex' => 'فرمت لینک گوگل مپ صحیح نیست.',
            'official_newspaper.mimes' => 'فرمت فایل روزنامه رسمی باید jpeg، png، svg یا pdf باشد.',
            'operation_licence.image' => 'فایل پروانه بهره برداری باید تصویر باشد.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
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
