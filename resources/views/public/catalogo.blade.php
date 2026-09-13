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

        @auth
            @if (auth()->user()->hasRole(\App\Models\Role::STUDENT))
                <div class="text-end mb-3">
                    <a href="{{ route('student.cart.index') }}" class="btn btn-outline-ce-primary">
                        <i class="bi bi-cart-fill me-1"></i>Ver mi carrito
                        @if (auth()->user()->cartItemsCount() > 0)
                            <span class="badge bg-ce-primary ms-1">{{ auth()->user()->cartItemsCount() }}</span>
                        @endif
                    </a>
                </div>
            @endif
        @endauth

        <div class="row g-4">
            @forelse ($productos as $producto)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge bg-ce-purple-light text-ce-purple mb-2">{{ $producto->productType?->nombre }}</span>
                                @if ($producto->level)
                                    <span class="badge bg-light text-dark border">{{ $producto->level->codigo }}</span>
                                @endif
                            </div>
                            <div class="text-center mb-3">
                                <i class="bi bi-mortarboard fs-1 text-ce-purple"></i>
                            </div>
                            <h5 class="fw-semibold">{{ $producto->nombre }}</h5>
                            <p class="text-muted small flex-grow-1">
                                {{ $producto->descripcion ?? 'Producto académico disponible para estudiantes registrados.' }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fs-5 fw-bold text-ce-purple">
                                    @if ($producto->currentPrice() != $producto->base_price)
                                        <del class="text-muted fs-6">${{ number_format($producto->base_price, 0, ',', '.') }}</del>
                                    @endif
                                    ${{ number_format($producto->currentPrice(), 0, ',', '.') }}
                                </span>
                                @auth
                                    @if (auth()->user()->hasRole(\App\Models\Role::STUDENT))
                                        <form method="POST" action="{{ route('student.cart.add', $producto) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-ce-primary btn-sm">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('contacto') }}" class="btn btn-ce-primary btn-sm">
                                            Solicitar
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-ce-primary btn-sm">
                                        Inicia sesión
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        Aún no hay productos publicados en el catálogo.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</section>

@endsection
