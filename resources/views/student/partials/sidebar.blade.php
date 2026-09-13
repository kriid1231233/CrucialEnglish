@php
    $activo = $activo ?? 'dashboard';
@endphp

<li class="nav-item">
    <a class="nav-link {{ $activo === 'dashboard' ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
        <i class="bi bi-speedometer2 me-2"></i>Panel principal
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $activo === 'grupos' ? 'active' : '' }}" href="{{ route('student.groups.index') }}">
        <i class="bi bi-diagram-3 me-2"></i>Mis grupos
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $activo === 'notas' ? 'active' : '' }}" href="{{ route('student.grades.index') }}">
        <i class="bi bi-clipboard-data me-2"></i>Mis notas
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $activo === 'materiales' ? 'active' : '' }}" href="{{ route('student.materials.index') }}">
        <i class="bi bi-file-earmark-text me-2"></i>Materiales
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('catalogo.index') }}">
        <i class="bi bi-bag me-2"></i>Catálogo
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $activo === 'carrito' ? 'active' : '' }}" href="{{ route('student.cart.index') }}">
        <i class="bi bi-cart-fill me-2"></i>Mi carrito
        @if (auth()->user()->cartItemsCount() > 0)
            <span class="badge bg-light text-dark ms-1">{{ auth()->user()->cartItemsCount() }}</span>
        @endif
    </a>
</li>
