<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MaterialController extends Controller
{
    /**
     * Materiales aprobados, priorizando los niveles en que el estudiante está inscrito.
     */
    public function index(): View
    {
        $student = Auth::user();

        $nivelesInscritos = $student->studentGroups()->pluck('nivel_id')->unique();

        $materiales = Material::with('level')
            ->where('estado', Material::STATUS_APPROVED)
            ->orderByRaw('FIELD(nivel_id, '.($nivelesInscritos->isEmpty() ? '0' : $nivelesInscritos->implode(',')).') DESC')
            ->orderBy('titulo')
            ->get();

        return view('student.materials.index', compact('materiales', 'nivelesInscritos'));
    }
}
