<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatrixRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deposit_product_id' => ['required', 'integer', 'exists:deposit_products,id'],
            'duration_months' => ['required', 'integer', 'min:1', 'max:120'],
            'interest_rate' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'deposit_product_id.required' => 'Produk deposito wajib dipilih.',
            'deposit_product_id.exists' => 'Produk deposito tidak valid.',
            'duration_months.required' => 'Tenor deposito wajib diisi.',
            'duration_months.min' => 'Tenor minimal 1 bulan.',
            'interest_rate.required' => 'Suku bunga wajib diisi.',
            'interest_rate.numeric' => 'Suku bunga harus berupa angka numerik valid.',
            'interest_rate.min' => 'Suku bunga minimal 0%.',
            'interest_rate.max' => 'Suku bunga maksimal 100%.',
        ];
    }
}
