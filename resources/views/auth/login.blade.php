@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
<h3 class="text-center mb-4">Iniciar Sesión</h3>

@if (session('status'))
    <div class="alert alert-success mb-3" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Contraseña -->
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Recordarme -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            Recordarme
        </label>
    </div>

    <!-- Botones -->
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
    </div>

    <!-- Enlaces -->
    <div class="text-center">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-link d-block mb-2">
                ¿Olvidaste tu contraseña?
            </a>
        @endif
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-link">
                ¿No tienes cuenta? Regístrate
            </a>
        @endif
    </div>
</form>
@endsection
