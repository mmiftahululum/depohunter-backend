<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:digital,konvensional,bpr'],
            'logo_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'description' => ['nullable', 'string'],
            'code_saham' => ['nullable', 'string', 'max:10'],
            'color_code' => ['nullable', 'string', 'max:20'],
            'is_lps_insured' => ['nullable', 'boolean'],
            'is_ojk_verified' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_lps_insured' => $this->boolean('is_lps_insured'),
            'is_ojk_verified' => $this->boolean('is_ojk_verified'),
            'color_code' => $this->input('color_code', '#000000') ?: '#000000',
        ]);
    }
}
