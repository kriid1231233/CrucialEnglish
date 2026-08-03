<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('academicGroup'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'level_id' => ['sometimes', 'exists:levels,id'],
            'teacher_id' => ['sometimes', 'exists:users,id'],
            'schedule_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre del grupo',
            'level_id' => 'nivel',
            'teacher_id' => 'docente',
            'schedule_description' => 'descripción de horario',
            'is_active' => 'activo',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'teacher_id.exists' => 'El docente seleccionado no existe.',
            'level_id.exists' => 'El nivel seleccionado no existe.',
        ];
    }
}
