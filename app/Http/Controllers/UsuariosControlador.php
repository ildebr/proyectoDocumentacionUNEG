<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;

class UsuariosControlador extends Controller
{
    //listar usuarios
    public function index(){
        $users = User::with('roles', 'permissions')->get();
        error_log($users);
        return view('admin.listuser')->with('users', $users);
    }
    //cambiar roles de usuario
    public function changeRoleGet($id){
        $user = User::with('roles', 'permissions')->find($id);
        // $prueba = $user->getDirectPermissions(); //Direct permissions
        // $user->getPermissionsViaRoles(); //permissions via roles
        //$user->getAllPermissions(); //all permissions
        // $prueba = $user->getRoleNames(); // get roles
        // echo $prueba;
        $roles = Role::all();
        $permission = Permission::all();
        return view('admin.changerole')->with(['user' => $user, 'roles' => $roles, 'permissions' => $permission]);
    }
    public function ChangeRolePost($id){
        $post = \Request::post();

        $user = User::find($id);
        $users = User::with('roles', 'permissions')->get();


        if ($post['form-name'] == 'rol'){
            if($post['accion'] == 'Agregar'){
                $user->assignRole($post['rol']);
            }elseif($post['accion'] == 'Eliminar'){
                $user->removeRole($post['rol']);
            }
        }else{
            if($post['accion'] == 'Agregar'){
                $user->givePermissionTo($post['permission']);
            }elseif($post['accion'] == 'Eliminar'){
                $user->revokePermissionTo($post['permission']);
            }
        }

        return view('admin.listuser')->with('users', $users);
    }
}
