<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;

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
    Route::get('/admin/listadeusuarios', function () {
        $users = App\Models\User::with('roles', 'permissions')->get();
        error_log($users);
        return view('admin.listuser')->with('users', $users);
    })->name('admin.listuser');
    
    //cambiar rol
    Route::get('/admin/cambiarRol/{id}', function($id){
        $user = User::with('roles', 'permissions')->find($id);
        // $prueba = $user->getDirectPermissions(); //Direct permissions
        // $user->getPermissionsViaRoles(); //permissions via roles
        //$user->getAllPermissions(); //all permissions
        // $prueba = $user->getRoleNames(); // get roles
        // echo $prueba;
        $roles = \Spatie\Permission\Models\Role::all();
        $permission = \Spatie\Permission\Models\Permission::all();
        return view('admin.changerole')->with(['user' => $user, 'roles' => $roles, 'permissions' => $permission]);
    });
    Route::post('/admin/cambiarRol/{id}/', function(Request $request,$id){
        $post = Request::post();

        $user = User::find($id);
        $users = App\Models\User::with('roles', 'permissions')->get();

        $uno =$post['form-name']=='rol';
        $dos = $post['accion']=='Agregar';

        echo $post['form-name'] . $post['accion'] . $uno . $dos;

        // if ($post['form-name'] == 'rol'){
        //     if($post['accion'] == 'Agregar'){
        //         $user->assignRole($post['rol']);
        //     }elseif($post['accion'] == 'Eliminar'){
        //         $user->removeRole($post['rol']);
        //     }
        // }else{
        //     if($post['accion'] == 'Agregar'){
        //         $user->givePermissionTo($post['permission']);
        //     }elseif($post['accion'] == 'Eliminar'){
        //         $user->revokePermissionTo($post['permission']);
        //     }
        // }

        // return view('admin.listuser')->with('users', $users);
    })->name('admin.changeuserroleorpermission');
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
