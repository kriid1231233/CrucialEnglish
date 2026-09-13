<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\AcademicGroupController as StudentAcademicGroupController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Student\MaterialController as StudentMaterialController;
use App\Http\Controllers\Student\CartController as StudentCartController;
use App\Models\Role;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::post('/inscripcion-rapida', [PublicController::class, 'quickEnroll'])->name('inscripcion.rapida');

Route::get('/catalogo', [PublicController::class, 'catalogo'])->name('catalogo.index');
Route::get('/nosotros', [PublicController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [PublicController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PublicController::class, 'contactoStore'])->name('contacto.store');

// Redirección al panel correspondiente según el rol activo del usuario
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole(Role::ADMIN)) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole(Role::TEACHER)) {
        return redirect()->route('teacher.dashboard');
    }

    if ($user->hasRole(Role::STUDENT)) {
        return redirect()->route('student.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel Administrador
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active', 'role:'.Role::ADMIN])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

// Panel Docente
Route::prefix('teacher')
    ->name('teacher.')
    ->middleware(['auth', 'active', 'role:'.Role::TEACHER])
    ->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    });

// Panel Estudiante
Route::prefix('student')
    ->name('student.')
    ->middleware(['auth', 'active', 'role:'.Role::STUDENT])
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-groups', [StudentAcademicGroupController::class, 'index'])->name('groups.index');
        Route::get('/my-groups/{academicGroup}', [StudentAcademicGroupController::class, 'show'])->name('groups.show');
        Route::get('/grades', [StudentGradeController::class, 'index'])->name('grades.index');
        Route::get('/materials', [StudentMaterialController::class, 'index'])->name('materials.index');
        Route::get('/cart', [StudentCartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{product}', [StudentCartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/items/{orderItem}', [StudentCartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/checkout', [StudentCartController::class, 'checkout'])->name('cart.checkout');
    });

require __DIR__.'/auth.php';