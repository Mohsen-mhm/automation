<?php

namespace App\Http\Requests\Panel;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(Permission::PERMISSION_ASSIGN);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'permissions' => 'دسترسی‌ها',
            'permissions.*' => 'دسترسی'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'permissions.array' => 'دسترسی‌ها باید آرایه باشد.',
            'permissions.*.integer' => 'دسترسی باید عدد باشد.',
            'permissions.*.exists' => 'دسترسی انتخاب شده معتبر نیست.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure permissions is always an array
        if (!$this->has('permissions')) {
            $this->merge(['permissions' => []]);
        }
    }
}
