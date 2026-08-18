@extends('layouts.public')

@section('title', 'Nosotros')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="fw-bold mb-3">Sobre CrucialEnglish</h1>
                <p class="lead text-muted">
                    Somos un instituto de inglés comprometido con la enseñanza personalizada
                    y el seguimiento real del progreso de cada estudiante.
                </p>
                <p>
                    Nuestra plataforma unifica clases individuales, grupales, materiales de
                    apoyo y contenido pregrabado en un solo lugar, permitiendo a estudiantes,
                    docentes y administradores trabajar de forma coordinada y transparente.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-building fs-1" style="font-size: 12rem; color: var(--ce-purple); opacity: 0.85;"></i>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-ce-purple-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <i class="bi bi-bullseye fs-1 text-ce-purple mb-3 d-block"></i>
                <h5 class="fw-semibold">Misión</h5>
                <p class="text-muted small">
                    Profesionalizar la enseñanza de inglés mediante herramientas digitales
                    propias, accesibles y centradas en el estudiante.
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-eye-fill fs-1 text-ce-purple mb-3 d-block"></i>
                <h5 class="fw-semibold">Visión</h5>
                <p class="text-muted small">
                    Ser el instituto de referencia en enseñanza de inglés con tecnología
                    propia en la región.
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-heart-fill fs-1 text-ce-purple mb-3 d-block"></i>
                <h5 class="fw-semibold">Valores</h5>
                <p class="text-muted small">
                    Cercanía, compromiso académico y mejora continua en cada nivel de enseñanza.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
