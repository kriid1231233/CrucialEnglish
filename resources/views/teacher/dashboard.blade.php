@extends('layouts.panel')

@section('title', 'Panel Docente')
@section('rol-label', 'Docente')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('teacher.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Panel principal
        </a>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-diagram-3 me-2"></i>Mis grupos
        </span>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-calendar-check me-2"></i>Sesiones de clase
        </span>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-file-earmark-text me-2"></i>Mis materiales
        </span>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-play-btn me-2"></i>Clases pregrabadas
        </span>
    </li>
@endsection

@section('content')
    <h2 class="fw-bold mb-1">Panel del Docente</h2>
    <p class="text-muted mb-4">Bienvenido(a), {{ Auth::user()->nombre }}.</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-diagram-3-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['grupos_activos'] }}</div>
                        <div class="text-muted small">Grupos activos</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['estudiantes_totales'] }}</div>
                        <div class="text-muted small">Estudiantes a cargo</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark-text fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['materiales_pendientes'] }}</div>
                        <div class="text-muted small">Materiales en revisión</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-play-btn fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['clases_pendientes'] }}</div>
                        <div class="text-muted small">Clases en revisión</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Mis grupos académicos</div>
                <ul class="list-group list-group-flush">
                    @forelse ($grupos as $grupo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $grupo->nombre }}</strong>
                                <div class="text-muted small">
                                    Nivel {{ $grupo->level?->codigo }} &middot; {{ $grupo->students_count }} estudiante(s)
                                </div>
                            </div>
                            <span class="badge bg-ce-primary">{{ $grupo->descripcion_horario }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Aún no tienes grupos asignados.</li>
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
    </div>
@endsection
