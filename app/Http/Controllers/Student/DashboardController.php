<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Panel principal del estudiante: sus grupos, notas, accesos y suscripciones.
     */
    public function index(): View
    {
        $student = Auth::user();

        $grupos = $student->studentGroups()
            ->with(['level', 'teacher'])
            ->wherePivot('activo', true)
            ->get();

        $proximasSesiones = ClassSession::whereIn('grupo_id', $grupos->pluck('id'))
            ->where('estado', 'scheduled')
            ->where('fecha_sesion', '>=', now()->toDateString())
            ->orderBy('fecha_sesion')
            ->orderBy('hora_inicio')
            ->with('academicGroup')
            ->take(5)
            ->get();

        $ultimasNotas = $student->grades()
            ->with('level')
            ->latest('fecha_evaluacion')
            ->take(5)
            ->get();

        $suscripcionesActivas = $student->subscriptions()
            ->where('estado', 'active')
            ->with('product')
            ->get();

        $accesosActivos = $student->accesses()
            ->where('activo', true)
            ->with('product')
            ->get();

        return view('student.dashboard', compact(
            'grupos',
            'proximasSesiones',
            'ultimasNotas',
            'suscripcionesActivas',
            'accesosActivos'
        ));
    }
}
