<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CrucialEnglish') }} - @yield('title', 'Panel')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --ce-primary: #253267;
            --ce-primary-dark: #182e6a;
            --ce-blue: #1265a1;
        }
        body { font-family: 'Figtree', sans-serif; background-color: #f5f7fb; }
        .btn-ce-primary { background-color: var(--ce-blue); border-color: var(--ce-blue); color: #fff; }
        .btn-ce-primary:hover { background-color: var(--ce-primary-dark); border-color: var(--ce-primary-dark); color: #fff; }
        .btn-outline-ce-primary { border-color: var(--ce-blue); color: var(--ce-blue); }
        .btn-outline-ce-primary:hover { background-color: var(--ce-blue); border-color: var(--ce-blue); color: #fff; }
        .text-ce-primary { color: var(--ce-primary) !important; }
        .panel-sidebar {
            min-height: calc(100vh - 56px);
            background-color: var(--ce-primary);
        }
        .panel-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
        }
        .panel-sidebar .nav-link.active,
        .panel-sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.12);
            border-radius: 0.375rem;
        }
        .stat-card {
            border: 0;
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.06);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark" style="background-color: var(--ce-primary);">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill me-2"></i> CrucialEnglish
            </a>
            <span class="badge bg-light text-dark me-3">@yield('rol-label', 'Panel')</span>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <span class="text-white-50 small d-none d-sm-inline">{{ Auth::user()->nombre }}</span>
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light">Mi Perfil</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 panel-sidebar py-4 px-0">
                <ul class="nav nav-pills flex-column px-2">
                    @yield('sidebar')
                </ul>
            </div>

            <div class="col-md-10 py-4">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
