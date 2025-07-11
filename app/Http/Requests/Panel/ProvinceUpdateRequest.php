<?php

namespace App\Http\Requests\Panel;

use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProvinceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(Province::PROVINCE_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $province = $this->route('province');

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('provinces', 'name')->ignore($province->id)
            ],
            'active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'نام استان',
            'active' => 'وضعیت',
            'sort_order' => 'ترتیب نمایش'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام استان الزامی است.',
            'name.min' => 'نام استان باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام استان نباید بیشتر از :max کاراکتر باشد.',
            'name.unique' => 'این نام استان قبلاً ثبت شده است.',
            'active.boolean' => 'وضعیت باید درست یا نادرست باشد.',
            'sort_order.integer' => 'ترتیب نمایش باید عدد صحیح باشد.',
            'sort_order.min' => 'ترتیب نمایش نمی‌تواند منفی باشد.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->boolean('active', true),
            'sort_order' => $this->integer('sort_order', 0)
        ]);
    }
}
