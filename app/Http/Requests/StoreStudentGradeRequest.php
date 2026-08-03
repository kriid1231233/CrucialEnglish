<?php

namespace App\Http\Requests;

use App\Models\StudentGrade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', StudentGrade::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:users,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'group_id' => ['nullable', 'exists:academic_groups,id'],
            'evaluation_type' => [
                'required',
                Rule::in([
                    StudentGrade::TYPE_TEST,
                    StudentGrade::TYPE_HOMEWORK,
                    StudentGrade::TYPE_ORAL,
                    StudentGrade::TYPE_FINAL
                ])
            ],
            'grade' => ['required', 'numeric', 'min:1.0', 'max:7.0'],
            'evaluation_date' => ['required', 'date', 'before_or_equal:today'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'student_id' => 'estudiante',
            'level_id' => 'nivel',
            'group_id' => 'grupo',
            'evaluation_type' => 'tipo de evaluación',
            'grade' => 'nota',
            'evaluation_date' => 'fecha de evaluación',
            'comments' => 'comentarios',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'grade.min' => 'La nota debe ser mínimo 1.0.',
            'grade.max' => 'La nota debe ser máximo 7.0.',
            'evaluation_date.before_or_equal' => 'La fecha de evaluación no puede ser futura.',
        ];
    }
}
