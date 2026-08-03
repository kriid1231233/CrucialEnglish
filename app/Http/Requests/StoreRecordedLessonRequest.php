<?php

namespace App\Http\Requests;

use App\Models\RecordedLesson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecordedLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', RecordedLesson::class);
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
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:300'],
            'video_path' => ['nullable', 'string', 'max:500'],
            'external_link' => ['nullable', 'url', 'max:500'],
            'status' => [
                'sometimes',
                Rule::in([RecordedLesson::STATUS_PENDING, RecordedLesson::STATUS_APPROVED, RecordedLesson::STATUS_REJECTED])
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
            $this->merge(['status' => RecordedLesson::STATUS_PENDING]);
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
