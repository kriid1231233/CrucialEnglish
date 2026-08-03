<?php

namespace App\Http\Requests;

use App\Models\Material;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Material::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'level_id' => ['required', 'exists:levels,id'],
            'file_type' => ['required', 'string', 'max:50'],
            'file_path' => ['nullable', 'string', 'max:500'],
            'external_link' => ['nullable', 'url', 'max:500'],
            'status' => [
                'sometimes',
                Rule::in([Material::STATUS_PENDING, Material::STATUS_APPROVED, Material::STATUS_REJECTED])
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Si no se proporciona status, establecer como pending
        if (!$this->has('status')) {
            $this->merge(['status' => Material::STATUS_PENDING]);
        }

        // Si no se proporciona author_id, usar el usuario autenticado
        if (!$this->has('author_id')) {
            $this->merge(['author_id' => $this->user()->id]);
        }
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
