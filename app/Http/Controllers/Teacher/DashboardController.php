<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSession;
use App\Models\Material;
use App\Models\RecordedLesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Panel principal del docente: sus grupos, próximas sesiones y contenidos.
     */
    public function index(): View
    {
        $teacher = Auth::user();

        $grupos = $teacher->teacherGroups()
            ->with('level')
            ->withCount('students')
            ->where('activo', true)
            ->get();

        $proximasSesiones = ClassSession::whereIn('grupo_id', $grupos->pluck('id'))
            ->where('estado', 'scheduled')
            ->where('fecha_sesion', '>=', now()->toDateString())
            ->orderBy('fecha_sesion')
            ->orderBy('hora_inicio')
            ->with('academicGroup')
            ->take(5)
            ->get();

        $stats = [
            'grupos_activos' => $grupos->count(),
            'estudiantes_totales' => $grupos->sum('students_count'),
            'materiales_pendientes' => Material::where('autor_id', $teacher->id)
                ->where('estado', Material::STATUS_PENDING)
                ->count(),
            'clases_pendientes' => RecordedLesson::where('autor_id', $teacher->id)
                ->where('estado', RecordedLesson::STATUS_PENDING)
                ->count(),
        ];

        return view('teacher.dashboard', compact('grupos', 'proximasSesiones', 'stats'));
    }
}
