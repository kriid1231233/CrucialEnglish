<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CrucialEnglish') }} - @yield('title', 'Instituto de Inglés')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --ce-primary: #253267;
            --ce-primary-dark: #182e6a;
            --ce-blue: #1265a1;
            --ce-blue-light: #1666a3;
            --ce-white: #ffffff;
            --ce-light-tint: #eef2fa;
        }
        body {
            font-family: 'Figtree', sans-serif;
        }
        .navbar-brand span {
            color: var(--ce-primary);
            font-weight: 700;
        }
        .btn-ce-primary {
            background-color: var(--ce-blue);
            border-color: var(--ce-blue);
            color: var(--ce-white);
        }
        .btn-ce-primary:hover {
            background-color: var(--ce-primary-dark);
            border-color: var(--ce-primary-dark);
            color: var(--ce-white);
        }
        .btn-outline-ce-primary {
            border-color: var(--ce-blue);
            color: var(--ce-blue);
        }
        .btn-outline-ce-primary:hover {
            background-color: var(--ce-blue);
            color: var(--ce-white);
        }
        .text-ce-primary {
            color: var(--ce-primary) !important;
        }
        .bg-ce-primary {
            background-color: var(--ce-primary) !important;
        }
        .bg-ce-light {
            background-color: var(--ce-light-tint) !important;
        }
        .hero-section {
            background: linear-gradient(135deg, var(--ce-primary) 0%, var(--ce-primary-dark) 100%);
            color: var(--ce-white);
        }
        .navbar-nav .nav-link.active {
            color: var(--ce-blue) !important;
            font-weight: 600;
        }
        footer a {
            color: #c7d3ec;
            text-decoration: none;
        }
        footer a:hover {
            color: var(--ce-white);
        }
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.12);
            color: var(--ce-white) !important;
            font-size: 1.1rem;
            transition: background-color 0.2s ease;
        }
        .social-icon:hover {
            background-color: var(--ce-blue);
            color: var(--ce-white) !important;
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Navbar público --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill text-ce-primary fs-3 me-2"></i>
                <span class="fs-4">CrucialEnglish</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalogo*') ? 'active' : '' }}" href="{{ route('catalogo.index') }}">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('nosotros') ? 'active' : '' }}" href="{{ route('nosotros') }}">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contacto') ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-ce-primary">Mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-ce-primary">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-ce-primary">Registrarse</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Contenido de cada página --}}
    <main class="flex-grow-1">
        @if (session('status'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer institucional --}}
    <footer class="bg-ce-primary text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="d-flex align-items-center mb-3">
                        <i class="bi bi-mortarboard-fill me-2"></i> CrucialEnglish
                    </h5>
                    <p class="small mb-3">
                        Plataforma integral de enseñanza de inglés: clases, materiales
                        y seguimiento académico en un solo lugar.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/crucial.english" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/crucialenglish.cl/" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="tel:+56992969031" class="social-icon" aria-label="Llamar por teléfono">
                            <i class="bi bi-telephone-fill"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-3">Enlaces</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('catalogo.index') }}">Catálogo de cursos</a></li>
                        <li class="mb-2"><a href="{{ route('nosotros') }}">Sobre nosotros</a></li>
                        <li class="mb-2"><a href="{{ route('contacto') }}">Contacto</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}">Crear cuenta</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-3">Contacto</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill me-2"></i>contacto@crucialenglish.cl
                        </li>
                        <li class="mb-2">
                            <a href="tel:+56992969031">
                                <i class="bi bi-telephone-fill me-2"></i>+56 9 9296 9031
                            </a>
                        </li>
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Santiago, Chile</li>
                        <li class="mb-2">
                            <a href="https://www.facebook.com/crucial.english" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-facebook me-2"></i>@ crucial.english
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="https://www.instagram.com/crucialenglish.cl/" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-instagram me-2"></i>@ crucialenglish.cl
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-light opacity-25 my-4">
            <p class="text-center small mb-0">
                &copy; {{ date('Y') }} CrucialEnglish. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
