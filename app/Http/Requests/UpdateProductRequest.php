<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('product'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'product_type_id' => ['sometimes', 'exists:product_types,id'],
            'level_id' => ['nullable', 'exists:levels,id'],
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('products', 'name')->ignore($productId)],
            'description' => ['sometimes', 'string'],
            'base_price' => ['sometimes', 'numeric', 'min:0', 'max:9999999.99'],
            'billing_mode' => [
                'sometimes',
                Rule::in([Product::BILLING_ONE_TIME, Product::BILLING_MONTHLY, Product::BILLING_PACKAGE])
            ],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'product_type_id' => 'tipo de producto',
            'level_id' => 'nivel',
            'name' => 'nombre',
            'description' => 'descripción',
            'base_price' => 'precio base',
            'billing_mode' => 'modo de facturación',
            'is_active' => 'activo',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'base_price.min' => 'El precio base no puede ser negativo.',
            'base_price.max' => 'El precio base no puede exceder 9,999,999.99.',
            'name.unique' => 'Ya existe un producto con este nombre.',
        ];
    }
}
