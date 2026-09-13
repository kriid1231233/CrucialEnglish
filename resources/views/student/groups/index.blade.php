@extends('layouts.panel')

@section('title', 'Mis Grupos')
@section('rol-label', 'Estudiante')

@section('sidebar')
    @include('student.partials.sidebar', ['activo' => 'grupos'])
@endsection

@section('content')
    <h2 class="fw-bold mb-1">Mis Grupos</h2>
    <p class="text-muted mb-4">Grupos académicos en los que estás inscrito actualmente.</p>

    <div class="row g-4">
        @forelse ($grupos as $grupo)
            <div class="col-lg-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-semibold mb-0">{{ $grupo->nombre }}</h5>
                            <span class="badge bg-ce-primary">{{ $grupo->level?->codigo }}</span>
                        </div>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-person-video3 me-1"></i>Docente: {{ $grupo->teacher?->nombre ?? 'Sin asignar' }}
                        </p>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar-week me-1"></i>{{ $grupo->descripcion_horario ?? 'Horario no definido' }}
                        </p>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-camera-video me-1"></i>{{ $grupo->class_sessions_count }} sesión(es) registradas
                        </p>
                        <a href="{{ route('student.groups.show', $grupo) }}" class="btn btn-sm btn-outline-ce-primary">
                            Ver detalle <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">
                    Aún no estás inscrito en ningún grupo académico. Revisa el
                    <a href="{{ route('catalogo.index') }}">catálogo de cursos</a> para inscribirte.
                </div>
            </div>
        @endforelse
    </div>
@endsection
