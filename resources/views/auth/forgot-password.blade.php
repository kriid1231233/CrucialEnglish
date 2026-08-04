@extends('layouts.guest')

@section('title', 'Recuperar Contraseña')

@section('content')
<h3 class="text-center mb-4">Recuperar Contraseña</h3>

<p class="text-muted mb-4">
    ¿Olvidaste tu contraseña? No hay problema. Ingresa tu email y te enviaremos un enlace para crear una nueva.
</p>

@if (session('status'))
    <div class="alert alert-success mb-3" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
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

    <!-- Botones -->
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Enviar Enlace de Recuperación</button>
    </div>

    <!-- Enlaces -->
    <div class="text-center">
        <a href="{{ route('login') }}" class="text-link">
            Volver al inicio de sesión
        </a>
    </div>
</form>
@endsection
