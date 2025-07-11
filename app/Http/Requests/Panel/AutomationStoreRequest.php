<?php

namespace App\Http\Requests\Panel;

use App\Models\Automation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Milwad\LaravelValidate\Rules\ValidUrl;

class AutomationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(Automation::AUTOMATION_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'greenhouse_id' => ['required', 'exists:greenhouses,id'],
            'climate_company_id' => ['nullable', 'exists:companies,id'],
            'climate_date' => ['nullable', 'string'],
            'climate_api_link' => ['nullable', 'string', new ValidUrl(), 'unique:automations,climate_api_link'],
            'climate_linked_date' => ['nullable', 'string'],
            'feeding_company_id' => ['nullable', 'exists:companies,id'],
            'feeding_date' => ['nullable', 'string'],
            'feeding_api_link' => ['nullable', 'string', new ValidUrl(), 'unique:automations,feeding_api_link'],
            'feeding_linked_date' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:pending,edited,confirmed,rejected,deactivate'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'greenhouse_id' => 'گلخانه',
            'climate_company_id' => 'شرکت مجری کنترل اقلیم',
            'climate_date' => 'تاریخ اجرای کنترل اقلیم',
            'climate_api_link' => 'لینک API کنترل اقلیم',
            'climate_linked_date' => 'تاریخ اتصال کنترل اقلیم',
            'feeding_company_id' => 'شرکت مجری تغذیه و آبیاری',
            'feeding_date' => 'تاریخ اجرای تغذیه و آبیاری',
            'feeding_api_link' => 'لینک API تغذیه و آبیاری',
            'feeding_linked_date' => 'تاریخ اتصال تغذیه و آبیاری',
            'status' => 'وضعیت',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'greenhouse_id.required' => 'انتخاب گلخانه الزامی است.',
            'greenhouse_id.exists' => 'گلخانه انتخاب شده معتبر نیست.',
            'climate_company_id.exists' => 'شرکت مجری کنترل اقلیم انتخاب شده معتبر نیست.',
            'feeding_company_id.exists' => 'شرکت مجری تغذیه و آبیاری انتخاب شده معتبر نیست.',
            'climate_api_link.unique' => 'این لینک API کنترل اقلیم قبلاً ثبت شده است.',
            'feeding_api_link.unique' => 'این لینک API تغذیه و آبیاری قبلاً ثبت شده است.',
        ];
    }
}
