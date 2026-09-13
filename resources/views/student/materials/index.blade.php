@extends('layouts.panel')

@section('title', 'Materiales')
@section('rol-label', 'Estudiante')

@section('sidebar')
    @include('student.partials.sidebar', ['activo' => 'materiales'])
@endsection

@section('content')
    <h2 class="fw-bold mb-1">Materiales de Apoyo</h2>
    <p class="text-muted mb-4">Guías y recursos aprobados, priorizados según tus niveles inscritos.</p>

    <div class="row g-4">
        @forelse ($materiales as $material)
            <div class="col-lg-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-semibold mb-0">{{ $material->titulo }}</h5>
                            <span class="badge {{ $nivelesInscritos->contains($material->nivel_id) ? 'bg-ce-primary' : 'bg-secondary' }}">
                                {{ $material->level?->codigo }}
                            </span>
                        </div>
                        <p class="text-muted small mb-3">{{ $material->descripcion ?? 'Sin descripción disponible.' }}</p>
                        @if ($material->enlace_externo)
                            <a href="{{ $material->enlace_externo }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-ce-primary">
                                Abrir recurso <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        @elseif ($material->ruta_archivo)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($material->ruta_archivo) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-ce-primary">
                                Descargar <i class="bi bi-download ms-1"></i>
                            </a>
                        @else
                            <span class="text-muted small">Recurso no disponible por el momento.</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">
                    Todavía no hay materiales aprobados disponibles.
                </div>
            </div>
        @endforelse
    </div>
@endsection
