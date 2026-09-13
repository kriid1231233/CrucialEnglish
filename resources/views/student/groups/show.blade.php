@extends('layouts.panel')

@section('title', $academicGroup->nombre)
@section('rol-label', 'Estudiante')

@section('sidebar')
    @include('student.partials.sidebar', ['activo' => 'grupos'])
@endsection

@section('content')
    <a href="{{ route('student.groups.index') }}" class="text-decoration-none small mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i>Volver a mis grupos
    </a>
    <h2 class="fw-bold mb-1">{{ $academicGroup->nombre }}</h2>
    <p class="text-muted mb-4">
        Nivel {{ $academicGroup->level?->codigo }} &middot;
        Docente: {{ $academicGroup->teacher?->nombre ?? 'Sin asignar' }} &middot;
        {{ $academicGroup->descripcion_horario ?? 'Horario no definido' }}
    </p>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Sesiones de clase</div>
                <ul class="list-group list-group-flush">
                    @forelse ($sesiones as $sesion)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $sesion->fecha_sesion->format('d/m/Y') }}</strong>
                                <div class="text-muted small">{{ $sesion->tema ?? 'Sin tema registrado' }}</div>
                            </div>
                            <span class="badge {{ $sesion->estado === 'completed' ? 'bg-success' : ($sesion->estado === 'cancelled' ? 'bg-danger' : 'bg-secondary') }}">
                                {{ $sesion->estado }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Aún no hay sesiones registradas para este grupo.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card stat-card h-100">
                <div class="card-header bg-white fw-semibold">Compañeros de grupo</div>
                <ul class="list-group list-group-flush">
                    @forelse ($companeros as $companero)
                        <li class="list-group-item">{{ $companero->nombre }}</li>
                    @empty
                        <li class="list-group-item text-muted">No hay más estudiantes activos en este grupo.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
