<?php

namespace App\Http\Requests;

use App\Models\Material;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('material'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'level_id' => ['sometimes', 'exists:levels,id'],
            'file_type' => ['sometimes', 'string', 'max:50'],
            'file_path' => ['nullable', 'string', 'max:500'],
            'external_link' => ['nullable', 'url', 'max:500'],
            'status' => [
                'sometimes',
                Rule::in([Material::STATUS_PENDING, Material::STATUS_APPROVED, Material::STATUS_REJECTED])
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'título',
            'description' => 'descripción',
            'level_id' => 'nivel',
            'file_type' => 'tipo de archivo',
            'file_path' => 'ruta del archivo',
            'external_link' => 'enlace externo',
            'status' => 'estado',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'external_link.url' => 'El enlace externo debe ser una URL válida.',
            'level_id.exists' => 'El nivel seleccionado no existe.',
        ];
    }
}
