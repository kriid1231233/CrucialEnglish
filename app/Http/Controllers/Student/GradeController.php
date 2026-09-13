<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Listado de todas las notas del estudiante autenticado.
     */
    public function index(): View
    {
        $notas = Auth::user()->grades()
            ->with(['level', 'academicGroup'])
            ->orderByDesc('fecha_evaluacion')
            ->get();

        $promedioGeneral = $notas->count() ? round($notas->avg('nota'), 1) : null;

        return view('student.grades.index', compact('notas', 'promedioGeneral'));
    }
}
