@extends('layouts.guest')

@section('title', 'Registro')

@section('content')
<h3 class="text-center mb-4">Crear Cuenta</h3>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Nombre -->
    <div class="mb-3">
        <label for="name" class="form-label">Nombre Completo</label>
        <input type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               id="name" 
               name="name" 
               value="{{ old('name') }}" 
               required 
               autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required>
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
        <div class="form-text">Mínimo 8 caracteres</div>
    </div>

    <!-- Confirmar Contraseña -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" 
               class="form-control @error('password_confirmation') is-invalid @enderror" 
               id="password_confirmation" 
               name="password_confirmation" 
               required>
        @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Botones -->
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Registrarse</button>
    </div>

    <!-- Enlaces -->
    <div class="text-center">
        <a href="{{ route('login') }}" class="text-link">
            ¿Ya tienes cuenta? Inicia sesión
        </a>
    </div>
</form>
@endsection
