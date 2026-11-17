<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bank_id' => ['required', 'exists:banks,id'],
            'name' => ['required', 'string', 'max:255'],
            'min_deposit' => ['required', 'numeric', 'min:0'],
            'referral_link' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'min_deposit' => str_replace(['Rp', '.', ' ', ','], ['', '', '', '.'], (string) $this->input('min_deposit', 0)),
        ]);
    }
}
