@extends('layouts.panel')

@section('title', 'Mis Notas')
@section('rol-label', 'Estudiante')

@section('sidebar')
    @include('student.partials.sidebar', ['activo' => 'notas'])
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <h2 class="fw-bold mb-0">Mis Notas</h2>
        @if ($promedioGeneral !== null)
            <span class="badge fs-6 {{ $promedioGeneral >= 4.0 ? 'bg-success' : 'bg-danger' }}">
                Promedio general: {{ number_format($promedioGeneral, 1) }}
            </span>
        @endif
    </div>
    <p class="text-muted mb-4">Historial de evaluaciones registradas en tus grupos académicos.</p>

    <div class="card stat-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Nivel</th>
                        <th>Grupo</th>
                        <th>Tipo de evaluación</th>
                        <th>Comentarios</th>
                        <th class="text-end">Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notas as $nota)
                        <tr>
                            <td>{{ $nota->fecha_evaluacion->format('d/m/Y') }}</td>
                            <td>{{ $nota->level?->codigo }}</td>
                            <td>{{ $nota->academicGroup?->nombre ?? '—' }}</td>
                            <td>{{ $nota->tipo_evaluacion }}</td>
                            <td class="text-muted small">{{ $nota->comentarios ?? '—' }}</td>
                            <td class="text-end">
                                <span class="badge {{ $nota->nota >= 4.0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ number_format($nota->nota, 1) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aún no tienes notas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
