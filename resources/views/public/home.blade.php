@extends('layouts.public')

@section('title', 'Inicio')

@section('content')

{{-- Hero --}}
<section class="hero-section py-5">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Aprende inglés con un instituto pensado para ti</h1>
                <p class="lead mb-4">
                    Clases individuales, grupales, materiales de apoyo y suscripciones,
                    todo en una sola plataforma. Avanza desde A1 hasta C2 con seguimiento
                    real de tu progreso.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg text-ce-purple fw-semibold">
                        Regístrate gratis
                    </a>
                    <a href="{{ route('catalogo.index') }}" class="btn btn-outline-light btn-lg">
                        Ver catálogo
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-mortarboard display-1" style="font-size: 14rem; opacity: 0.85;"></i>
            </div>
        </div>
    </div>
</section>

{{-- Servicios / propuesta de valor --}}
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">¿Qué ofrecemos?</h2>
            <p class="text-muted">Todo lo que necesitas para avanzar en tu nivel de inglés</p>
        </div>

        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-person-video3 fs-1 text-ce-purple"></i>
                    </div>
                    <h5 class="fw-semibold">Clases Individuales</h5>
                    <p class="text-muted small mb-0">Atención personalizada con un docente dedicado a tu ritmo.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-people-fill fs-1 text-ce-purple"></i>
                    </div>
                    <h5 class="fw-semibold">Clases Grupales</h5>
                    <p class="text-muted small mb-0">Aprende junto a otros estudiantes de tu mismo nivel.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text-fill fs-1 text-ce-purple"></i>
                    </div>
                    <h5 class="fw-semibold">Materiales de Apoyo</h5>
                    <p class="text-muted small mb-0">Guías, ejercicios y recursos descargables por nivel.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-play-circle-fill fs-1 text-ce-purple"></i>
                    </div>
                    <h5 class="fw-semibold">Clases Pregrabadas</h5>
                    <p class="text-muted small mb-0">Suscríbete y accede a nuestra videoteca completa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Niveles --}}
<section class="py-5 bg-ce-purple-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Progresa por niveles reales</h2>
            <p class="text-muted">Del A1 al C2, con seguimiento de notas y asistencia en cada etapa</p>
        </div>
        <div class="d-flex justify-content-center flex-wrap gap-3">
            @foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $nivel)
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                     style="width: 90px; height: 90px;">
                    <span class="fw-bold fs-4 text-ce-purple">{{ $nivel }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Call to action final --}}
<section class="py-5">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-3">¿Listo para empezar?</h2>
        <p class="text-muted mb-4">Crea tu cuenta gratis y explora nuestro catálogo de cursos</p>
        <a href="{{ route('register') }}" class="btn btn-ce-primary btn-lg px-5">
            Comenzar ahora
        </a>
    </div>
</section>

@endsection
