<?php

namespace App\Http\Requests\Panel;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isActive();
    }

    public function rules(): array
    {
        $user = auth()->user();

        if ($user->hasRole(Role::COMPANY_ROLE)) {
            return $this->companyRules();
        } elseif ($user->hasRole(Role::GREENHOUSE_ROLE)) {
            return $this->greenhouseRules();
        } elseif ($user->hasRole(Role::ORGANIZATION_ROLE)) {
            return $this->organizationRules();
        }

        return [];
    }

    private function companyRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'type' => ['required', 'string', 'max:100'],
            'national_id' => ['required', 'string', 'min:4'],
            'registration_number' => ['required', 'string'],
            'registration_place' => ['required', 'string', 'max:100'],
            'registration_date' => ['required', 'string'],
            'climate_system' => ['boolean'],
            'feeding_system' => ['boolean'],
            'ceo_name' => ['required', 'string', 'max:100'],
            'ceo_phone' => ['required', 'string', new ValidPhoneNumber()],
            'ceo_national_id' => ['required', 'string', new ValidNationalCard()],
            'interface_name' => ['required', 'string', 'max:100'],
            'interface_phone' => ['required', 'string', new ValidPhoneNumber()],
            'company_logo' => ['nullable', 'image', 'max:2048'],
            'brand' => ['required', 'string', 'max:100'],
            'brand_logo' => ['nullable', 'image', 'max:2048'],
            'trademark_certificate' => ['nullable', 'image', 'max:2048'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['required', 'string', new ValidPhoneNumber()],
            'phone_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'location_link' => ['required', 'string', new ValidUrl()],
            'website' => ['required', 'string', 'url', 'max:200'],
            'email' => ['required', 'email', 'max:100'],
            'official_newspaper' => ['nullable', 'file', 'mimes:jpeg,png,svg,pdf', 'max:5120'],
            'operation_licence' => ['nullable', 'image', 'max:2048'],
        ];
    }

    private function greenhouseRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'licence_number' => ['required', 'string'],
            'substrate_type' => ['required', 'string'],
            'product_type' => ['required', 'string'],
            'meterage' => ['required', 'string'],
            'greenhouse_status' => ['required', 'string'],
            'construction_date' => ['nullable', 'string'],
            'operation_date' => ['nullable', 'string'],
            'owner_name' => ['required', 'string', 'max:100'],
            'owner_national_id' => ['required', 'string', new ValidNationalCard()],
            'owner_phone' => ['required', 'string', new ValidPhoneNumber()],
            'climate_system' => ['boolean'],
            'feeding_system' => ['boolean'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'location_link' => ['nullable', 'string', new ValidUrl()],
            'operation_licence' => ['nullable', 'image', 'max:2048'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    private function organizationRules(): array
    {
        return [
            'fname' => ['required', 'string', 'max:50'],
            'lname' => ['required', 'string', 'max:50'],
            'national_id' => ['required', 'string', new ValidNationalCard()],
            'organization_name' => ['required', 'string', 'max:100'],
            'organization_level' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'phone_number' => ['required', 'string', new ValidPhoneNumber()],
            'national_card' => ['nullable', 'image', 'max:2048'],
            'personnel_card' => ['nullable', 'image', 'max:2048'],
            'introduction_letter' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام',
            'fname' => 'نام',
            'lname' => 'نام خانوادگی',
            'type' => 'نوع شرکت',
            'national_id' => 'شناسه ملی / کد ملی',
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
            'province' => 'استان',
            'city' => 'شهر',
            'address' => 'آدرس',
            'postal' => 'کد پستی',
            'landline_number' => 'تلفن ثابت',
            'phone_number' => 'تلفن همراه',
            'location_link' => 'لینک موقعیت',
            'website' => 'وب سایت',
            'email' => 'ایمیل',
            'official_newspaper' => 'روزنامه رسمی',
            'operation_licence' => 'پروانه بهره برداری',
            'licence_number' => 'شماره پروانه',
            'substrate_type' => 'نوع بستر',
            'product_type' => 'نوع محصول',
            'meterage' => 'متراژ',
            'greenhouse_status' => 'وضعیت گلخانه',
            'construction_date' => 'تاریخ احداث',
            'operation_date' => 'تاریخ بهره برداری',
            'owner_name' => 'نام مالک',
            'owner_national_id' => 'کد ملی مالک',
            'owner_phone' => 'تلفن مالک',
            'image' => 'تصویر گلخانه',
            'organization_name' => 'سازمان',
            'organization_level' => 'سمت سازمانی',
            'national_card' => 'کارت ملی',
            'personnel_card' => 'کارت پرسنلی',
            'introduction_letter' => 'معرفی نامه',
        ];
    }
}
