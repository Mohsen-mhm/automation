<?php

namespace App\Http\Requests\Panel;

use App\Models\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ConfigUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(Config::CONFIG_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $config = $this->route('config');

        $rules = [
            'title' => 'required|string|min:2|max:255',
        ];

        // Handle different config types
        if ($config && $config->type == Config::JSON_TYPE) {
            $rules['value'] = 'required|array|min:1';
            $rules['value.*'] = 'required|string|max:255';
        } else {
            $rules['value'] = 'required|string|max:1000';
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'value' => 'مقدار',
            'value.*' => 'مقدار',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الزامی است.',
            'title.min' => 'عنوان باید حداقل :min کاراکتر باشد.',
            'title.max' => 'عنوان نباید بیشتر از :max کاراکتر باشد.',
            'value.required' => 'مقدار الزامی است.',
            'value.array' => 'مقدار باید آرایه باشد.',
            'value.min' => 'حداقل یک مقدار وارد کنید.',
            'value.*.required' => 'مقدار نمی‌تواند خالی باشد.',
            'value.*.max' => 'مقدار نباید بیشتر از :max کاراکتر باشد.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $config = $this->route('config');

        // Handle JSON type values
        if ($config && $config->type == Config::JSON_TYPE) {
            if ($this->has('json_values') && is_array($this->json_values)) {
                // Filter out empty values
                $filteredValues = array_filter($this->json_values, function ($value) {
                    return !empty(trim($value));
                });

                $this->merge([
                    'value' => array_values($filteredValues)
                ]);
            }
        }
    }
}
