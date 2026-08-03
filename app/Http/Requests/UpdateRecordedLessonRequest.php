<?php

namespace App\Http\Requests;

use App\Models\RecordedLesson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRecordedLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('recordedLesson'));
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
            'duration_minutes' => ['sometimes', 'integer', 'min:1', 'max:300'],
            'video_path' => ['nullable', 'string', 'max:500'],
            'external_link' => ['nullable', 'url', 'max:500'],
            'status' => [
                'sometimes',
                Rule::in([RecordedLesson::STATUS_PENDING, RecordedLesson::STATUS_APPROVED, RecordedLesson::STATUS_REJECTED])
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
            'duration_minutes' => 'duración en minutos',
            'video_path' => 'ruta del video',
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
            'duration_minutes.min' => 'La duración debe ser al menos 1 minuto.',
            'duration_minutes.max' => 'La duración no puede exceder 300 minutos (5 horas).',
            'external_link.url' => 'El enlace externo debe ser una URL válida.',
            'level_id.exists' => 'El nivel seleccionado no existe.',
        ];
    }
}
