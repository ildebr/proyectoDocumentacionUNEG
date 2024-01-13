<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Http\Controllers\UsuariosControlador;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

//login routes
Route::middleware('guest')->group(function(){
    Route::get('', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('', [AuthenticatedSessionController::class, 'store']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//administrador
Route::get('/admin', function(){
    return view('admin.index');
})->middleware(['auth','role:administrador'])->name('admin.index');

Route::middleware(['auth','role:administrador'])->group(function(){
    Route::get('/admin/listadeusuarios', [UsuariosControlador::class, 'index'])->name('admin.listuser');
    
    //cambiar rol
    Route::get('/admin/cambiarRol/{id}', [UsuariosControlador::class, 'changeRoleGet']);
    Route::post('/admin/cambiarRol/{id}/', [UsuariosControlador::class, 'changeRolePost'])->name('admin.changeuserroleorpermission');
});

Route::get('/admin/crearusuario', function(){
    $roles = \Spatie\Permission\Models\Role::all();
    return view('admin.createuser')->with('roles', $roles);
})->middleware(['auth','role:administrador'])->name('admin.createuser');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
