@extends('layouts.panel')

@section('title', 'Panel Administrador')
@section('rol-label', 'Administrador')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Panel principal
        </a>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-people me-2"></i>Usuarios
        </span>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-bag me-2"></i>Productos
        </span>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-diagram-3 me-2"></i>Grupos académicos
        </span>
    </li>
    <li class="nav-item">
        <span class="nav-link disabled">
            <i class="bi bi-file-earmark-check me-2"></i>Contenidos por aprobar
        </span>
    </li>
@endsection

@section('content')
    <h2 class="fw-bold mb-1">Panel de Administración</h2>
    <p class="text-muted mb-4">Resumen general de la plataforma CrucialEnglish.</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['estudiantes'] }}</div>
                        <div class="text-muted small">Estudiantes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-video3 fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['docentes'] }}</div>
                        <div class="text-muted small">Docentes</div>
                    </div>
                </div>
            </div>
        </div>
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
                    <i class="bi bi-cart-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['ordenes_pendientes'] }}</div>
                        <div class="text-muted small">Órdenes pendientes</div>
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
                        <div class="text-muted small">Materiales por aprobar</div>
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
                        <div class="text-muted small">Clases pregrabadas por aprobar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-envelope-fill fs-2 text-ce-primary me-3"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $stats['mensajes_sin_leer'] }}</div>
                        <div class="text-muted small">Mensajes sin leer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Últimos mensajes de contacto</div>
                <ul class="list-group list-group-flush">
                    @forelse ($ultimosMensajes as $mensaje)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $mensaje->nombre }}</strong>
                                <small class="text-muted">{{ $mensaje->creado_en->diffForHumans() }}</small>
                            </div>
                            <div class="text-muted small">{{ $mensaje->email }}</div>
                            <div class="small mt-1">{{ \Illuminate\Support\Str::limit($mensaje->mensaje, 100) }}</div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No hay mensajes recientes.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Grupos académicos recientes</div>
                <ul class="list-group list-group-flush">
                    @forelse ($ultimosGrupos as $grupo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $grupo->nombre }}</strong>
                                <div class="text-muted small">
                                    Nivel {{ $grupo->level?->codigo }} &middot;
                                    Docente: {{ $grupo->teacher?->nombre ?? 'Sin asignar' }}
                                </div>
                            </div>
                            <span class="badge {{ $grupo->activo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $grupo->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No hay grupos registrados aún.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
