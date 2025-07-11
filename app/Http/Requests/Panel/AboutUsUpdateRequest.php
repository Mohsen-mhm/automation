<?php

namespace App\Http\Requests\Panel;

use App\Models\AboutUs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AboutUsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(AboutUs::ABOUT_US_EDIT);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'description' => 'required|string|min:10|max:20000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'description' => 'محتوا',
            'image' => 'تصویر'
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
            'description.required' => 'محتوا الزامی است.',
            'description.min' => 'محتوا باید حداقل :min کاراکتر باشد.',
            'description.max' => 'محتوا نباید بیشتر از :max کاراکتر باشد.',
            'image.image' => 'فایل انتخابی باید یک تصویر باشد.',
            'image.mimes' => 'فرمت تصویر باید یکی از این فرمت‌ها باشد: jpeg, png, jpg, gif, webp',
            'image.max' => 'حجم تصویر نباید بیشتر از :max کیلوبایت باشد.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean up description content if needed
        if ($this->has('description')) {
            $description = $this->input('description');

            // Remove any potentially harmful scripts or unwanted tags
            $description = strip_tags($description, '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><a><blockquote><code>');

            $this->merge([
                'description' => $description
            ]);
        }
    }
}
