@extends('layouts.guest')

@section('title', 'Restablecer Contraseña')

@section('content')
<h3 class="text-center mb-4">Nueva Contraseña</h3>

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email', $request->email) }}" 
               required 
               autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Nueva Contraseña -->
    <div class="mb-3">
        <label for="password" class="form-label">Nueva Contraseña</label>
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

    <!-- Botón -->
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-lg">Restablecer Contraseña</button>
    </div>
</form>
@endsection
