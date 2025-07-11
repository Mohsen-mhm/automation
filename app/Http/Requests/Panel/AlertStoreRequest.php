<?php

namespace App\Http\Requests\Panel;

use App\Models\GreenhouseAlert;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AlertStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole(Role::GREENHOUSE_ROLE) ||
            Gate::allows(GreenhouseAlert::ALERT_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'lux_active' => ['required', 'boolean'],
            'min_lux' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'max_lux' => ['nullable', 'integer', 'min:0', 'max:100000', 'gte:min_lux'],

            'temp_active' => ['required', 'boolean'],
            'min_temp' => ['nullable', 'integer', 'min:-50', 'max:100'],
            'max_temp' => ['nullable', 'integer', 'min:-50', 'max:100', 'gte:min_temp'],

            'wind_active' => ['required', 'boolean'],
            'min_wind' => ['nullable', 'integer', 'min:0', 'max:500'],
            'max_wind' => ['nullable', 'integer', 'min:0', 'max:500', 'gte:min_wind'],

            'humidity_active' => ['required', 'boolean'],
            'min_humidity' => ['nullable', 'integer', 'min:0', 'max:100'],
            'max_humidity' => ['nullable', 'integer', 'min:0', 'max:100', 'gte:min_humidity'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'lux_active' => 'فعال‌سازی روشنایی',
            'min_lux' => 'حداقل روشنایی',
            'max_lux' => 'حداکثر روشنایی',
            'temp_active' => 'فعال‌سازی دما',
            'min_temp' => 'حداقل دما',
            'max_temp' => 'حداکثر دما',
            'wind_active' => 'فعال‌سازی سرعت باد',
            'min_wind' => 'حداقل سرعت باد',
            'max_wind' => 'حداکثر سرعت باد',
            'humidity_active' => 'فعال‌سازی رطوبت',
            'min_humidity' => 'حداقل رطوبت',
            'max_humidity' => 'حداکثر رطوبت',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'min_lux.required_if' => 'در صورت فعال‌سازی روشنایی، حداقل مقدار الزامی است.',
            'max_lux.required_if' => 'در صورت فعال‌سازی روشنایی، حداکثر مقدار الزامی است.',
            'max_lux.gte' => 'حداکثر روشنایی باید بزرگتر یا مساوی حداقل روشنایی باشد.',

            'min_temp.required_if' => 'در صورت فعال‌سازی دما، حداقل مقدار الزامی است.',
            'max_temp.required_if' => 'در صورت فعال‌سازی دما، حداکثر مقدار الزامی است.',
            'max_temp.gte' => 'حداکثر دما باید بزرگتر یا مساوی حداقل دما باشد.',

            'min_wind.required_if' => 'در صورت فعال‌سازی سرعت باد، حداقل مقدار الزامی است.',
            'max_wind.required_if' => 'در صورت فعال‌سازی سرعت باد، حداکثر مقدار الزامی است.',
            'max_wind.gte' => 'حداکثر سرعت باد باید بزرگتر یا مساوی حداقل سرعت باد باشد.',

            'min_humidity.required_if' => 'در صورت فعال‌سازی رطوبت، حداقل مقدار الزامی است.',
            'max_humidity.required_if' => 'در صورت فعال‌سازی رطوبت، حداکثر مقدار الزامی است.',
            'max_humidity.gte' => 'حداکثر رطوبت باید بزرگتر یا مساوی حداقل رطوبت باشد.',

            'min_lux.min' => 'حداقل روشنایی نمی‌تواند منفی باشد.',
            'min_lux.max' => 'حداقل روشنایی نمی‌تواند بیشتر از 100000 لوکس باشد.',
            'max_lux.min' => 'حداکثر روشنایی نمی‌تواند منفی باشد.',
            'max_lux.max' => 'حداکثر روشنایی نمی‌تواند بیشتر از 100000 لوکس باشد.',

            'min_temp.min' => 'حداقل دما نمی‌تواند کمتر از -50 درجه باشد.',
            'min_temp.max' => 'حداقل دما نمی‌تواند بیشتر از 100 درجه باشد.',
            'max_temp.min' => 'حداکثر دما نمی‌تواند کمتر از -50 درجه باشد.',
            'max_temp.max' => 'حداکثر دما نمی‌تواند بیشتر از 100 درجه باشد.',

            'min_wind.min' => 'حداقل سرعت باد نمی‌تواند منفی باشد.',
            'min_wind.max' => 'حداقل سرعت باد نمی‌تواند بیشتر از 500 کیلومتر بر ساعت باشد.',
            'max_wind.min' => 'حداکثر سرعت باد نمی‌تواند منفی باشد.',
            'max_wind.max' => 'حداکثر سرعت باد نمی‌تواند بیشتر از 500 کیلومتر بر ساعت باشد.',

            'min_humidity.min' => 'حداقل رطوبت نمی‌تواند منفی باشد.',
            'min_humidity.max' => 'حداقل رطوبت نمی‌تواند بیشتر از 100 درصد باشد.',
            'max_humidity.min' => 'حداکثر رطوبت نمی‌تواند منفی باشد.',
            'max_humidity.max' => 'حداکثر رطوبت نمی‌تواند بیشتر از 100 درصد باشد.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkboxes to boolean values
        $this->merge([
            'lux_active' => (bool)$this->input('lux_active', false),
            'temp_active' => (bool)$this->input('temp_active', false),
            'wind_active' => (bool)$this->input('wind_active', false),
            'humidity_active' => (bool)$this->input('humidity_active', false),
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Custom validation for conditional required fields
            if ($this->input('lux_active')) {
                if (is_null($this->input('min_lux')) || is_null($this->input('max_lux'))) {
                    $validator->errors()->add('lux_error', 'در صورت انتخاب روشنایی محیط، مقادیر حداقل و حداکثر الزامی است.');
                }
            }

            if ($this->input('temp_active')) {
                if (is_null($this->input('min_temp')) || is_null($this->input('max_temp'))) {
                    $validator->errors()->add('temp_error', 'در صورت انتخاب دمای محیط، مقادیر حداقل و حداکثر الزامی است.');
                }
            }

            if ($this->input('wind_active')) {
                if (is_null($this->input('min_wind')) || is_null($this->input('max_wind'))) {
                    $validator->errors()->add('wind_error', 'در صورت انتخاب سرعت باد محیط، مقادیر حداقل و حداکثر الزامی است.');
                }
            }

            if ($this->input('humidity_active')) {
                if (is_null($this->input('min_humidity')) || is_null($this->input('max_humidity'))) {
                    $validator->errors()->add('humidity_error', 'در صورت انتخاب رطوبت محیط، مقادیر حداقل و حداکثر الزامی است.');
                }
            }
        });
    }
}
