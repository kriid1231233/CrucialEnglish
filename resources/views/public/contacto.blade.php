@extends('layouts.public')

@section('title', 'Contacto')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Contáctanos</h1>
            <p class="text-muted">¿Tienes dudas? Escríbenos y te responderemos a la brevedad</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if (session('contacto_enviado'))
                    <div class="alert alert-success">
                        {{ session('contacto_enviado') }}
                    </div>
                @endif

                {{--
                    NOTA PARA CONEXIÓN A BACKEND:
                    action="{{ route('contacto.store') }}" — crear ContactoController@store
                    que valide y guarde en la tabla contact_messages (RF-006).
                --}}
                <form method="POST" action="#" class="card border-0 shadow-sm p-4">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control @error('mensaje') is-invalid @enderror"
                                  id="mensaje" name="mensaje" rows="5" required>{{ old('mensaje') }}</textarea>
                        @error('mensaje')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-ce-primary w-100">
                        <i class="bi bi-send-fill me-2"></i>Enviar mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
