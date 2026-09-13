<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AcademicGroupController extends Controller
{
    /**
     * Listado de los grupos académicos en los que el estudiante está inscrito.
     */
    public function index(): View
    {
        $grupos = Auth::user()->studentGroups()
            ->with(['level', 'teacher'])
            ->withCount('classSessions')
            ->get();

        return view('student.groups.index', compact('grupos'));
    }

    /**
     * Detalle de un grupo académico: sesiones de clase y compañeros.
     */
    public function show(AcademicGroup $academicGroup): View
    {
        $this->authorize('view', $academicGroup);

        $academicGroup->load(['level', 'teacher']);

        $sesiones = $academicGroup->classSessions()
            ->orderByDesc('fecha_sesion')
            ->orderByDesc('hora_inicio')
            ->get();

        $companeros = $academicGroup->activeStudents()->get();

        return view('student.groups.show', compact('academicGroup', 'sesiones', 'companeros'));
    }
}
