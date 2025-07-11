<?php

namespace App\Http\Requests\Panel;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CityStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(City::CITY_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'province_id' => 'required|exists:provinces,id',
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('cities')->where(function ($query) {
                    return $query->where('province_id', $this->province_id);
                })
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
            'province_id' => 'استان',
            'name' => 'نام شهر',
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
            'province_id.required' => 'انتخاب استان الزامی است.',
            'province_id.exists' => 'استان انتخاب شده معتبر نیست.',
            'name.required' => 'نام شهر الزامی است.',
            'name.min' => 'نام شهر باید حداقل :min کاراکتر باشد.',
            'name.max' => 'نام شهر نباید بیشتر از :max کاراکتر باشد.',
            'name.unique' => 'این نام شهر در استان انتخاب شده قبلاً ثبت شده است.',
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
