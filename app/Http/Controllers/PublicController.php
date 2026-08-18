<?php

namespace App\Http\Controllers;

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
     * Catálogo público de productos.
     *
     * NOTA: por ahora la vista usa datos de ejemplo ($productosDemo).
     * Cuando se implemente el Módulo Catálogo, reemplazar por:
     * $productos = Producto::where('activo', true)->paginate(9);
     * return view('public.catalogo', compact('productos'));
     */
    public function catalogo()
    {
        return view('public.catalogo');
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
}
