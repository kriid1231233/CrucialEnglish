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
            <div class="col-lg-6">
                {{-- Inscripción rápida: guarda el interés del visitante y lo redirige a crear su cuenta --}}
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4 text-dark">
                        <h5 class="fw-bold mb-1"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Inscripción rápida</h5>
                        <p class="text-muted small mb-3">Déjanos tus datos y continúa creando tu cuenta en segundos.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger small py-2">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('inscripcion.rapida') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control" placeholder="Nombre completo"
                                       value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control" placeholder="Correo electrónico"
                                       value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <select name="nivel_interes" class="form-select">
                                    <option value="">Nivel de interés (opcional)</option>
                                    @foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $nivel)
                                        <option value="{{ $nivel }}">{{ $nivel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-ce-primary w-100 fw-semibold">
                                Quiero inscribirme <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
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

        @php
            $niveles = [
                'A1' => [
                    'nombre' => 'Principiante',
                    'resumen' => 'Alfabeto, saludos, presentaciones, números y vocabulario básico de uso diario.',
                    'resultado' => 'Comunicarse en frases simples sobre necesidades cotidianas.',
                ],
                'A2' => [
                    'nombre' => 'Elemental',
                    'resumen' => 'Presente y pasado simple, rutinas, compras, familia y descripciones sencillas.',
                    'resultado' => 'Mantener conversaciones cortas sobre temas familiares.',
                ],
                'B1' => [
                    'nombre' => 'Intermedio',
                    'resumen' => 'Tiempos verbales combinados, opiniones, planes futuros y comprensión de textos simples.',
                    'resultado' => 'Desenvolverse en la mayoría de situaciones de viaje y trabajo.',
                ],
                'B2' => [
                    'nombre' => 'Intermedio Alto',
                    'resumen' => 'Condicionales, voz pasiva, argumentación y comprensión de textos complejos.',
                    'resultado' => 'Interactuar con fluidez y espontaneidad con hablantes nativos.',
                ],
                'C1' => [
                    'nombre' => 'Avanzado',
                    'resumen' => 'Matices de significado, lenguaje académico/profesional y redacción formal.',
                    'resultado' => 'Usar el idioma de forma flexible y eficaz en contextos exigentes.',
                ],
                'C2' => [
                    'nombre' => 'Dominio',
                    'resumen' => 'Perfeccionamiento de fluidez, precisión y matices culturales del idioma.',
                    'resultado' => 'Comunicarse con precisión casi nativa en cualquier contexto.',
                ],
            ];
        @endphp

        <div class="row g-4">
            @foreach ($niveles as $codigo => $nivel)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3"
                                      style="width: 56px; height: 56px; flex-shrink: 0;">
                                    <span class="fw-bold fs-5 text-ce-purple">{{ $codigo }}</span>
                                </span>
                                <h5 class="fw-semibold mb-0">{{ $nivel['nombre'] }}</h5>
                            </div>
                            <p class="small mb-2"><strong>Resumen de materia:</strong> {{ $nivel['resumen'] }}</p>
                            <p class="small text-muted mb-0"><strong>Resultado esperado:</strong> {{ $nivel['resultado'] }}</p>
                        </div>
                    </div>
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

