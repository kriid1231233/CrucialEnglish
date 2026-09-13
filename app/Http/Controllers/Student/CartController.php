<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Muestra el carrito (orden pendiente) del estudiante autenticado.
     */
    public function index(): View
    {
        $carrito = Auth::user()->cartOrder();

        $items = $carrito ? $carrito->items()->with('product.productType', 'product.level')->get() : collect();

        return view('student.cart.index', compact('carrito', 'items'));
    }

    /**
     * Agrega un producto al carrito. Si ya está agregado, incrementa la cantidad.
     */
    public function add(Product $product): RedirectResponse
    {
        if (!$product->activo) {
            return back()->with('error', 'Este producto ya no está disponible.');
        }

        $student = Auth::user();

        $carrito = Order::firstOrCreate(
            ['estudiante_id' => $student->id, 'estado' => Order::STATUS_PENDING],
            ['monto_total' => 0]
        );

        $item = $carrito->items()->where('producto_id', $product->id)->first();
        $precioUnitario = $product->currentPrice();

        if ($item) {
            $item->cantidad += 1;
            $item->subtotal = $item->cantidad * $precioUnitario;
            $item->save();
        } else {
            $carrito->items()->create([
                'producto_id' => $product->id,
                'cantidad' => 1,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $precioUnitario,
            ]);
        }

        $carrito->update(['monto_total' => $carrito->items()->sum('subtotal')]);

        return back()->with('status', 'Producto agregado al carrito.');
    }

    /**
     * Elimina un item del carrito del estudiante autenticado.
     */
    public function remove(OrderItem $orderItem): RedirectResponse
    {
        $carrito = $orderItem->order;

        if ($carrito->estudiante_id !== Auth::id() || $carrito->estado !== Order::STATUS_PENDING) {
            abort(403);
        }

        $orderItem->delete();
        $carrito->update(['monto_total' => $carrito->items()->sum('subtotal')]);

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    /**
     * Confirma el pedido. La integración de pago (Webpay Plus) se habilitará
     * en una etapa posterior; por ahora solo deja la orden lista para pago.
     */
    public function checkout(): RedirectResponse
    {
        $carrito = Auth::user()->cartOrder();

        if (!$carrito || $carrito->items()->count() === 0) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        return back()->with('status', 'Pedido confirmado. La pasarela de pago (Webpay Plus) estará disponible próximamente; nuestro equipo te contactará para completar el pago.');
    }
}
