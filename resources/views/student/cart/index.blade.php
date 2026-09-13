@extends('layouts.panel')

@section('title', 'Mi Carrito')
@section('rol-label', 'Estudiante')

@section('sidebar')
    @include('student.partials.sidebar', ['activo' => 'carrito'])
@endsection

@section('content')
    <h2 class="fw-bold mb-1">Mi Carrito</h2>
    <p class="text-muted mb-4">Revisa los productos seleccionados antes de confirmar tu pedido.</p>

    <div class="card stat-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Nivel</th>
                        <th class="text-end">Precio unitario</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product?->nombre }}</strong>
                                <div class="text-muted small">{{ $item->product?->productType?->nombre }}</div>
                            </td>
                            <td>{{ $item->product?->level?->codigo ?? '—' }}</td>
                            <td class="text-end">${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->cantidad }}</td>
                            <td class="text-end">${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('student.cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Quitar del carrito">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tu carrito está vacío. Explora el
                                <a href="{{ route('catalogo.index') }}">catálogo de cursos</a> para agregar productos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($items->isNotEmpty())
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th class="text-end">${{ number_format($carrito->monto_total, 0, ',', '.') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    @if ($items->isNotEmpty())
        <div class="d-flex justify-content-end mt-3">
            <form method="POST" action="{{ route('student.cart.checkout') }}">
                @csrf
                <button type="submit" class="btn btn-ce-primary btn-lg">
                    <i class="bi bi-credit-card me-1"></i>Confirmar pedido y pagar
                </button>
            </form>
        </div>
    @endif
@endsection
