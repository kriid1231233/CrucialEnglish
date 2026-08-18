@extends('layouts.public')

@section('title', 'Catálogo')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Catálogo de Cursos</h1>
            <p class="text-muted">Elige el producto académico que se ajuste a tus objetivos</p>
        </div>

        {{-- Filtros (maqueta, sin lógica todavía) --}}
        <div class="row mb-4 g-2 justify-content-center">
            <div class="col-md-3">
                <select class="form-select" disabled>
                    <option>Todos los tipos</option>
                    <option>Clase Individual</option>
                    <option>Clase Grupal</option>
                    <option>Material de Apoyo</option>
                    <option>Suscripción</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" disabled>
                    <option>Todos los niveles</option>
                    <option>A1</option>
                    <option>A2</option>
                    <option>B1</option>
                    <option>B2</option>
                    <option>C1</option>
                    <option>C2</option>
                </select>
            </div>
        </div>

        {{--
            NOTA PARA CONEXIÓN A BACKEND:
            Reemplazar este array estático por $productos (colección Eloquent)
            proveniente de ProductoController@index, con paginación.
        --}}
        @php
            $productosDemo = [
                ['nombre' => 'Inglés Individual A1-A2', 'tipo' => 'Clase Individual', 'nivel' => 'A1-A2', 'precio' => 45000, 'icono' => 'bi-person-video3'],
                ['nombre' => 'Grupo Conversacional B1', 'tipo' => 'Clase Grupal', 'nivel' => 'B1', 'precio' => 28000, 'icono' => 'bi-people-fill'],
                ['nombre' => 'Guía de Gramática Completa', 'tipo' => 'Material de Apoyo', 'nivel' => 'Todos', 'precio' => 12000, 'icono' => 'bi-file-earmark-text-fill'],
                ['nombre' => 'Suscripción Mensual Premium', 'tipo' => 'Suscripción', 'nivel' => 'Todos', 'precio' => 25000, 'icono' => 'bi-play-circle-fill'],
                ['nombre' => 'Preparación Business English C1', 'tipo' => 'Clase Individual', 'nivel' => 'C1', 'precio' => 52000, 'icono' => 'bi-briefcase-fill'],
                ['nombre' => 'Grupo Intensivo B2', 'tipo' => 'Clase Grupal', 'nivel' => 'B2', 'precio' => 32000, 'icono' => 'bi-people-fill'],
            ];
        @endphp

        <div class="row g-4">
            @foreach ($productosDemo as $producto)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge bg-ce-purple-light text-ce-purple mb-2">{{ $producto['tipo'] }}</span>
                                <span class="badge bg-light text-dark border">{{ $producto['nivel'] }}</span>
                            </div>
                            <div class="text-center mb-3">
                                <i class="bi {{ $producto['icono'] }} fs-1 text-ce-purple"></i>
                            </div>
                            <h5 class="fw-semibold">{{ $producto['nombre'] }}</h5>
                            <p class="text-muted small flex-grow-1">
                                Producto académico disponible para estudiantes registrados.
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fs-5 fw-bold text-ce-purple">
                                    ${{ number_format($producto['precio'], 0, ',', '.') }}
                                </span>
                                @auth
                                    <button class="btn btn-ce-primary btn-sm" disabled title="Lógica de carrito pendiente">
                                        Agregar
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-ce-primary btn-sm">
                                        Inicia sesión
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
