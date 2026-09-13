<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicGroup;
use App\Models\ContactMessage;
use App\Models\Material;
use App\Models\Order;
use App\Models\RecordedLesson;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Panel principal del administrador: indicadores generales de la plataforma.
     */
    public function index(): View
    {
        $stats = [
            'estudiantes' => User::whereHas('roles', fn ($q) => $q->where('identificador', Role::STUDENT))->count(),
            'docentes' => User::whereHas('roles', fn ($q) => $q->where('identificador', Role::TEACHER))->count(),
            'grupos_activos' => AcademicGroup::where('activo', true)->count(),
            'ordenes_pendientes' => Order::where('estado', Order::STATUS_PENDING)->count(),
            'materiales_pendientes' => Material::where('estado', Material::STATUS_PENDING)->count(),
            'clases_pendientes' => RecordedLesson::where('estado', RecordedLesson::STATUS_PENDING)->count(),
            'mensajes_sin_leer' => ContactMessage::whereNull('leido_en')->count(),
        ];

        $ultimosMensajes = ContactMessage::latest()->take(5)->get();

        $ultimosGrupos = AcademicGroup::with(['level', 'teacher'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimosMensajes', 'ultimosGrupos'));
    }
}
