<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Transacción para asegurar consistencia de datos
        $user = DB::transaction(function () use ($request) {
            // 1. Crear usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'active' => true,
                'email_verified_at' => now(),
            ]);

            // 2. Crear perfil de estudiante automáticamente
            StudentProfile::create([
                'user_id' => $user->id,
                'phone' => null,
                'birth_date' => null,
                'contact_preferences' => null,
                'availability_notes' => null,
            ]);

            // 3. Asignar rol de estudiante
            $studentRole = Role::where('slug', 'estudiante')->first();
            if ($studentRole) {
                $user->roles()->attach($studentRole->id, [
                    'assigned_at' => now(),
                    'assigned_by' => null, // Autoasignado en registro
                ]);
            }

            return $user;
        });

        // 4. Enviar email de bienvenida
        try {
            Mail::to($user)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            // Log del error pero no interrumpir el registro
            \Log::warning('No se pudo enviar email de bienvenida: ' . $e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        // 5. Establecer rol activo en sesión
        session(['active_role' => 'estudiante']);

        return redirect(route('dashboard', absolute: false));
    }
}
