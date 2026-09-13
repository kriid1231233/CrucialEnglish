<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Página de inicio (landing institucional).
     */
    public function home()
    {
        return view('public.home');
    }

    /**
     * Inscripción rápida desde la portada: registra el interés del visitante
     * (se guarda como mensaje de contacto) y lo redirige al formulario de
     * registro con sus datos precargados para completar la creación de cuenta.
     */
    public function quickEnroll(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nivel_interes' => ['nullable', 'string', 'max:10'],
        ]);

        ContactMessage::create([
            'nombre' => $data['name'],
            'email' => $data['email'],
            'mensaje' => 'Solicitud de inscripción rápida desde la página principal.'
                .(!empty($data['nivel_interes']) ? ' Nivel de interés: '.$data['nivel_interes'] : ''),
        ]);

        return redirect()
            ->route('register')
            ->withInput(['name' => $data['name'], 'email' => $data['email']])
            ->with('status', '¡Gracias! Completa tu contraseña para finalizar tu inscripción.');
    }

    /**
     * Catálogo público de productos.
     */
    public function catalogo()
    {
        $productos = Product::with(['productType', 'level', 'offers'])
            ->where('activo', true)
            ->orderBy('nombre')
            ->paginate(9);

        return view('public.catalogo', compact('productos'));
    }

    /**
     * Página "Sobre nosotros".
     */
    public function nosotros()
    {
        return view('public.nosotros');
    }

    /**
     * Formulario de contacto.
     */
    public function contacto()
    {
        return view('public.contacto');
    }

    /**
     * Guarda un mensaje enviado desde el formulario de contacto público.
     */
    public function contactoStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mensaje' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'mensaje' => $data['mensaje'],
        ]);

        return redirect()
            ->route('contacto')
            ->with('contacto_enviado', 'Tu mensaje fue enviado correctamente. Te contactaremos pronto.');
    }
}
