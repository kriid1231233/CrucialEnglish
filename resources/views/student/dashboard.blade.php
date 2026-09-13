@extends('layouts.panel')

@section('title', 'Panel Estudiante')
@section('rol-label', 'Estudiante')

@section('sidebar')
    @include('student.partials.sidebar', ['activo' => 'dashboard'])
@endsection

@section('content')
    <h2 class="fw-bold mb-1">Panel del Estudiante</h2>
    <p class="text-muted mb-4">Bienvenido(a), {{ Auth::user()->nombre }}.</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-diagram-3-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $grupos->count() }}</div>
                        <div class="text-muted small">Grupos activos</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clipboard-data-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $ultimasNotas->count() }}</div>
                        <div class="text-muted small">Notas recientes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-arrow-repeat fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $suscripcionesActivas->count() }}</div>
                        <div class="text-muted small">Suscripciones activas</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-unlock-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $accesosActivos->count() }}</div>
                        <div class="text-muted small">Accesos vigentes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Mis grupos</div>
                <ul class="list-group list-group-flush">
                    @forelse ($grupos as $grupo)
                        <li class="list-group-item">
                            <strong>{{ $grupo->nombre }}</strong>
                            <div class="text-muted small">
                                Nivel {{ $grupo->level?->codigo }} &middot; Docente: {{ $grupo->teacher?->nombre ?? 'Sin asignar' }}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Aún no estás inscrito en ningún grupo.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Próximas sesiones</div>
                <ul class="list-group list-group-flush">
                    @forelse ($proximasSesiones as $sesion)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $sesion->academicGroup?->nombre }}</strong>
                                <small class="text-muted">{{ $sesion->fecha_sesion->format('d/m/Y') }}</small>
                            </div>
                            <div class="text-muted small">{{ $sesion->tema }}</div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No tienes sesiones programadas próximamente.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Últimas notas</div>
                <ul class="list-group list-group-flush">
                    @forelse ($ultimasNotas as $nota)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $nota->tipo_evaluacion }}</strong>
                                <div class="text-muted small">Nivel {{ $nota->level?->codigo }}</div>
                            </div>
                            <span class="badge {{ $nota->nota >= 4.0 ? 'bg-success' : 'bg-danger' }}">
                                {{ number_format($nota->nota, 1) }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Aún no tienes notas registradas.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Suscripciones y accesos</div>
                <ul class="list-group list-group-flush">
                    @forelse ($suscripcionesActivas as $suscripcion)
                        <li class="list-group-item">
                            <strong>{{ $suscripcion->product?->nombre }}</strong>
                            <div class="text-muted small">
                                Vigente hasta {{ optional($suscripcion->termina_en)->format('d/m/Y') ?? 'sin fecha límite' }}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No tienes suscripciones activas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
