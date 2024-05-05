<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Models\sdd090d;
use App\Models\sdd080d;
use App\Models\sdd100d;
use App\Models\sdd200d;
use App\Models\sdd210d;

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

Route::get('generate-pdf', [App\Http\Controllers\PdfController::class, 'generatePdf']);
Route::get('generate-pdf-tematica/{lapso}/{carrera}/{asignatura}/{version}', [App\Http\Controllers\PdfController::class, 'generateTematicaPdf'])->name('pdf.generarTematica');

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
    })->name('admin.changeuserroleorpermission');
});

Route::get('/admin/crearusuario', function(){
    $roles = \Spatie\Permission\Models\Role::all();
    return view('admin.createuser')->with('roles', $roles);
})->middleware(['auth','role:administrador'])->name('admin.createuser');

// Route::get('/plan/asignatura/crear', function(){
//     return view('general.cargaplan');
// })->middleware(['auth','role:administrador'])->name('general.crearplan');

Route::get('/plan/crear', function () {
    return view('general.crearplan');
})->name('general.crearplan');

Route::get('/plan/asignarplan', function () {
    $users = App\Models\User::all();
    error_log($users);
    return view('general.asignarplan')->with('users', $users);
})->name('general.asignarplan');

Route::get('/plan/asignarasignatura', function (Request $request) {
    //obtenemos los usuarios para la lista de las personas a las que se les puede asignar una asignatura
    $users = App\Models\User::whereNotNull('cedula')->get();
    
    error_log(json_encode(Request::input('asignatura')));

    //se seleccionan los parametros query en el link del buscador
    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    $seleccionadas = Request::input('asignatura');

    $error = '';

    $selresults = '';
    //se verifica que los datos necesarios esten presentes, al contrario se manda un error
    if($lapso == '' || $carrera == '' || $seleccionadas == ''){
        $error = 'Falta alguno de los datos necesarios para funcionar esta accion';
    }else{
        // si no hay un error en el link se verifica que las asignaturas seleccionadas existan de nuevo
        // $seltext = implode(",",$seleccionadas);
        $seltext = "`".implode("`, `",$seleccionadas)."`";
        // $result = DB::select(DB::raw("select * from sdd090ds asign where asign.sdd090d_lapso_vigencia ='".$lapso."' AND asign.sdd090d_cod_carr='".$carrera."' AND sdd090d_cod_asign in (".$seltext.")"));

        // Se chequea que las asignaturas existan y los datos correspondan
        $selresults=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->whereIn('sdd090d_cod_asign', $seleccionadas)->get();

        if($selresults->isEmpty()){
            $error = 'No hay resultados que mostrar para los datos ingresados. Asegurate de haber ingresado datos validos';
        }
    }

    return view('general.asignarasignatura')->with('data',['users'=> $users, 'seleccionadas' => $seleccionadas, 'lapso'=>$lapso, 'carrera'=>$carrera, 'error'=>$error])->with(compact('selresults'));
})->middleware(['auth','role:administrador'])->name('general.asignarasignatura');

Route::post('/plan/asignarasignatura', function (Request $request) {
    
    // error_log(Request::input('tipo_asignacion'));

    $tipo = Request::input('tipo_asignacion');
    $asignado = Request::input('asignado');
    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    $asignaturas = Request::input('asignaturas');
    $usuario = Request::input('user-plan');

    error_log(json_encode($asignaturas));
    error_log($usuario);
    error_log($lapso);
    error_log($carrera);

    $indirecta = '';
    $directa = '';

    if($tipo == 'directa'){
        $directa = $usuario;
        $tipo = 'd';
    }else{
        $indirecta = $usuario;
        $tipo = 'i';
    }

    $error = '';

    if($lapso == '' || $carrera == '' || count($asignaturas) <=0){
        $error = 'Falta alguno de los datos necesarios para funcionar esta accion';
        return view('general.asignarasignatura')->with('data',['error'=>$error]);
    }else{
        $selresults=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->whereIn('sdd090d_cod_asign', $asignaturas)->get();

        foreach ($selresults as $asignatura){
            $asignacion = sdd200d::updateOrCreate(
                [
                    'sdd200d_plan_asignatura_id' => (int)$asignatura->id,
                    'sdd200d_cod_asign'=> $asignatura->sdd090d_cod_asign,
                    'sdd200d_nom_asign'=> $asignatura->sdd090d_nom_asign,
                    'sdd200d_lapso_vigencia' => $asignatura->sdd090d_lapso_vigencia,
                ],
                [
                    'sdd200d_plan_asignatura_id' => (int)$asignatura->id,
                    'sdd200d_cod_carr' => $carrera,
                    'sdd200d_cod_asign'=> $asignatura->sdd090d_cod_asign,
                    'sdd200d_nom_asign'=> $asignatura->sdd090d_nom_asign,
                    'sdd200d_lapso_vigencia' => $asignatura->sdd090d_lapso_vigencia,
                    'sdd200d_inferior_asignado' => $indirecta,
                    'sdd200d_superior_asignado' => $directa,
                    'sdd200d_estado' => 'a',
            ]);
        }

        return redirect()->route('general.listarasignaturaslapsocarrera', ['lapso' => $lapso, 'carrera' => $carrera]);
    }

    //obtenemos los usuarios para la lista de las personas a las que se les puede asignar una asignatura
    $users = App\Models\User::all();
    //se seleccionan las asignaturas
    $asignaturas = App\Models\sdd090d::all();
    // error_log(json_encode(Request::input('asignatura')));

    //se seleccionan los parametros query en el link del buscador
    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    $seleccionadas = Request::input('asignatura');

    $error = '';

    $selresults = '';
    //se verifica que los datos necesarios esten presentes, al contrario se manda un error
    // if($lapso == '' || $carrera == '' || $seleccionadas == ''){
    //     $error = 'Falta alguno de los datos necesarios para funcionar esta accion';
    // }else{
    //     // si no hay un error en el link se verifica que las asignaturas seleccionadas existan de nuevo
    //     // $seltext = implode(",",$seleccionadas);
    //     $seltext = "`".implode("`, `",$seleccionadas)."`";
    //     // $result = DB::select(DB::raw("select * from sdd090ds asign where asign.sdd090d_lapso_vigencia ='".$lapso."' AND asign.sdd090d_cod_carr='".$carrera."' AND sdd090d_cod_asign in (".$seltext.")"));

    //     $selresults=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->whereIn('sdd090d_cod_asign', $seleccionadas)->get();

    //     if($selresults->isEmpty()){
    //         $error = 'No hay resultados que mostrar para los datos ingresados. Asegurate de haber ingresado datos validos';
    //     }
    // }
    // return view('general.asignarasignatura')->with('data',['users'=> $users, 'asignaturas'=> $asignaturas, 'seleccionadas' => $seleccionadas, 'lapso'=>$lapso, 'carrera'=>$carrera, 'error'=>$error])->with(compact('selresults'));
})->middleware(['auth','role:administrador'])->name('general.asignarasignaturapost');

//asignacion directa
Route::get('/plan/asignarasignatura/directo/{lapso}/{carrera}/{asignatura}', function(Request $request, $lapso, $carrera, $asignatura){
    $error ='';
    error_log($lapso);
    error_log($carrera);
    error_log($asignatura);
    error_log(Auth::user()->cedula);

    if($lapso == '' || $carrera == '' || $asignatura == ''){
        $error = 'Falta un parametro de busqueda';
        return view ('general.asignarasignaturadirecta')->with(compact('error'));
    }else{
        //se revisa que el usuario con la sesion activa este asignado como superior en la asignatura indicada
        $asignado = App\Models\sdd200d::where('sdd200d_superior_asignado', '=', Auth::user()->cedula)->where('sdd200d_cod_carr','=',$carrera)->where('sdd200d_cod_asign','=',$asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->get();

        $users = App\Models\User::whereNotNull('cedula')->get();
        error_log($asignado);
        error_log(App\Models\sdd200d::where('sdd200d_superior_asignado', '=', Auth::user()->cedula)->where('sdd200d_cod_carr','=',$carrera)->where('sdd200d_cod_asign','=',$asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->toSql());

        if($asignado){
            return view ('general.asignarasignaturadirecta')->with(compact('error','asignado','users','lapso','carrera','asignatura'));
        }else{
            $error = 'No estas asignado como supervisor de esta asignatura o no existe una asignatura con los valores indicados';
            return view ('general.asignarasignaturadirecta')->with(compact('error'));
        }
    }

})->middleware(['auth'])->name('general.asignarasignaturadirecta');

Route::post('/plan/asignarasignatura/directo/{lapso}/{carrera}/{asignatura}', function(Request $request){
    $error ='';

    error_log(Auth::user()->cedula);

    $tipo = Request::input('tipo_asignacion');
    $asignado = Request::input('asignado');
    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    $asignatura = Request::input('asignaturas');
    $usuario = Request::input('user-plan');

    if($lapso == '' || $carrera == '' || count($asignatura) <=0){
        $error = 'Falta alguno de los datos necesarios para funcionar esta accion';
        return view ('general.asignarasignaturadirecta')->with(compact('error'));
    }else{
        //revisamos que la asignatura exista
        $selresults=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->where('sdd090d_cod_asign', $asignatura)->first();
        //revisamos que el usuario haciendo la asignacion sea el supervisor de la asignatura
        $asignado = App\Models\sdd200d::where('sdd200d_superior_asignado', '=', Auth::user()->cedula)->where('sdd200d_cod_carr','=',$carrera)->where('sdd200d_cod_asign','=',$asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();
        error_log(json_encode($selresults));
        error_log($asignado);

        if($asignado && $selresults){
            $asignacion = sdd200d::where('id',$asignado['id'])->update(
                [
                    'sdd200d_inferior_asignado' => $usuario,
                    'sdd200d_estado' => 'a',
            ]);

            if($asignacion){
                $error = 'Asegurate de que los datos ingresados sean los correctos';
                $status = 'Asignado exitosamente';
                // return view ('general.asignarasignaturadirecta')->with(compact('error'));
                return redirect()->route('plan.mostrarasignados')->with('status', '¡Asignado existosamente!')->with(compact('error', 'status'));
            }else{
                $error = 'No pudo ser actualizada';
                return view ('general.asignarasignaturadirecta')->with(compact('error'));
            }
        }else{
            $error = 'Asegurate de que los datos ingresados sean los correctos';
            return view ('general.asignarasignaturadirecta')->with(compact('error'));
        }        
    }

})->middleware(['auth'])->name('general.asignarasignaturadirecta');


Route::get('/plan/asignado', function(){
    error_log(Auth::user()->cedula);
    $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
    $puede_asignar = false;

    $status = '';

    error_log(json_encode($asignados));
    return view('plan.mostrarasignados')->with(compact('asignados', 'status'));
})->middleware(['auth'])->name('plan.mostrarasignados');


Route::get('/plan/asignatura/cargar', function(){
    return view('general.cargaplan');
})->middleware(['auth','role:administrador'])->name('general.cargarplan');

// Route::get('/plan/asignar', function(){
//     return view('general.asignaraplan');
// })->middleware(['auth','role:administrador'])->name('general.asignarplan');


//Relacionar asignaturas
Route::get('/asignatura/relacion', function(){
    $carreras = App\Models\sdd080d::all();
    return view('carrera.listarcarreras')->with('carreras',$carreras);
})->middleware(['auth','role:administrador'])->name('general.listarcarreras');

//Carrera
Route::get('/carrera/lista', function(){
    $carreras = App\Models\sdd080d::all();
    return view('carrera.listarcarreras')->with('carreras',$carreras);
})->middleware(['auth','role:administrador'])->name('general.listarcarreras');

//Asignaturas

Route::get('/asignaturas/lista', function(){
    $asignaturas = App\Models\sdd090d::all();
    return view('general.listarasignaturas')->with('asignaturas',$asignaturas);
})->middleware(['auth','role:administrador'])->name('general.listarasignaturas');




//Asignaturas de una carrera
Route::get('/carrera/{carrera}/asignaturas/lista', function(Request $reques,$carrera){
    $asignaturas = App\Models\sdd090d::all()->where('sdd090d_cod_carr', '2072');
    error_log($carrera);
    // $asignaturas = App\Models\sdd090d::where('sdd090d_cod_carr', '2072');
    // $asignaturas = DB::table('sdd090d')->selectRaw("* WHERE sdd090d_cod_carr = '?' ", [$carrera])->get();
    return view('general.listarasignaturas')->with('asignaturas',$asignaturas);
})->middleware(['auth','role:administrador'])->name('general.listarasignaturascarrera');

//Asignaturas de una carrera filtradas por plan
Route::get('/{lapso}/{carrera}/asignaturas/lista', function(Request $reques,$lapso,$carrera){

    // $asignaturas = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->get();
    // se obtienen las asignaturas de la carrera seleccionada en el lapso academico seleccionado
    // $asignaturas = DB::table('sdd090ds')->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado')->leftjoin('sdd200ds', function($join){
    //     $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    // })->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->get();

    $asignaturas = DB::table('sdd090ds')->distinct()->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado', 'sdd210ds_version')->leftjoin('sdd200ds', function($join){
        $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    })->leftjoin('sdd210ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
    })->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd210ds_version', 'ASC')->get();
    
    
    error_log(DB::table('sdd090ds')->distinct()->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado', 'sdd210ds_version')->leftjoin('sdd200ds', function($join){
        $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    })->leftjoin('sdd210ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
    })->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd210ds_version', 'ASC')->toSql());


    // error_log(json_encode($asignaturas));
    // error_log(DB::table('sdd090ds')->select('sdd200ds.id as status_id','*')->leftjoin('sdd200ds', function($join){
    //     $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    // })->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->toSql());


    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();
    
    // return view('general.listarasignaturasplancarrera')->with('asignaturas',$asignaturas);
    return view('general.listarasignaturasplancarrera',compact('asignaturas', 'carrera', 'lapso'));
})->middleware(['auth','role:administrador'])->name('general.listarasignaturaslapsocarrera');

//Relacion de asignaturas
Route::get('/{lapso}/{carrera}/relacion/crear', function(Request $reques,$lapso,$carrera){

    $asignaturas = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->get();
    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();
    return view('asignaturas.relacionarasignaturas',compact('asignaturas', 'carrera', 'lapso'));
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionarasignaturas');


//Creacion-detalle planes
Route::get('/{lapso}/{carrera}/{asignatura}/crear', function(Request $request,$lapso,$carrera,$asignatura){
    error_log(Auth::user()->hasRole('administrador'));

    // se verifica que la asignatura exista y se obtiene su informacion
    $asignaturaDetalle = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();

    if(!$asignaturaDetalle){
        // di no existe la asignatura se retorna un error
        abort(403, 'No existe esta pagina');
    }


    // se revisa que existe en la tabla detalle de plan
    $existeplan = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->get()->first();

    if($existeplan){
        // si existe un plan se manda a la vista editar
        return redirect()->route('general.planeditar', ['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura]);
    }

    // si es administrador puede ver cualquier pagina
    if(Auth::user()->hasRole('administrador')){
        
        return view('general.cargaplandetalle')->with('asignatura', $asignaturaDetalle);
    }else{
        // Revisa que el usuario con la sesion activa este asignado
        // limitar a que vea solo a la que esta asignado
        $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
        
        //si no esta asignado retorna error
        if(count($asignados) ==0){
            abort(403, 'No tienes permiso para ver esta pagina');
        }else{
            return view('general.cargaplandetalle')->with('asignatura', $asignaturaDetalle);
        }
    }
    
})->middleware(['auth'])->name('general.plancrear');

Route::get('/{lapso}/{carrera}/{asignatura}/{version}/editar', function(Request $request,$lapso,$carrera,$asignatura){
    error_log(Auth::user()->hasRole('administrador'));

    $asignaturaDetalle = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    
    if(!$asignaturaDetalle){
        // si no existe la asignatura se retorna un error
        abort(403, 'No existe esta pagina');
    }

    // se revisa que existe en la tabla detalle de plan
    $plan = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->get()->first();
    error_log(json_encode($plan));
    if(!$plan){
        // si no existe un plan se manda a la vista crear
        return redirect()->route('general.plancrear',['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura]);
    }

    $estado = DB::table('sdd200ds')->select('sdd200d_estado')->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();

    // si es administrador puede ver cualquier pagina
    if(Auth::user()->hasRole('administrador')){
        return view('general.cargaplandetalleeditar')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado'));
    }else{
        // Revisa que el usuario con la sesion activa este asignado
        // limitar a que vea solo a la que esta asignado
        $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
        
        //si no esta asignado retorna error
        if(count($asignados) ==0){
            abort(403, 'No tienes permiso para ver esta pagina');
        }else{
            return view('general.cargaplandetalleeditar')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado'));
        }
    }
})->middleware(['auth'])->name('general.planeditar');

// cargar datos del plan
Route::post('/{lapso}/{carrera}/{asignatura}/crear', function(Request $request,$lapso,$carrera,$asignatura){
    error_log(json_encode(Request::all()));
    // update or create state 

    //se verifica que la asignatura exista
    $existeasignatura=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->where('sdd090d_cod_asign', $asignatura)->first();
    // se revisa que el usuario este asignado a la asignatura, ya sea como superior o inferior
    // $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
    $asignado = App\Models\sdd200d::where('sdd200d_lapso_vigencia','=',$lapso)->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', $asignatura)->where(function ($query){
        $query->where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula);
    })->first();

    
    // si existe la asignatura
    if($existeasignatura){
        // si el usuario con la sesion activa esta asignado se actualiza el estado
        if($asignado){
            if($asignado->sdd200d_superior_asignado == Auth::user()->cedula){
                // si es el superior se envia al jefe de departamento
                $asignado->sdd200d_estado = 'rj';
                $asignado->save();

                sdd210d::updateOrCreate(
                    [
                        'sdd210d_cod_carr' => $asignado->sdd200d_cod_carr,
                        'sdd210d_cod_asign' =>  $asignado->sdd200d_cod_asign,
                        'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia
                    ],
                    [
                        'sdd210ds_as_proposito' =>Request::input('proposito'),
                        'sdd210ds_as_competencias_genericas' =>Request::input('comp_genericas'),
                        'sdd210ds_a_competencias_profesionales' =>Request::input('comp_profesionales'),
                        'sdd210ds_s_competencias_profesionales_basicas' =>Request::input('comp_profesionales_basicas'),
                        'sdd210ds_s_competencias_profesionales_especificas' =>Request::input('comp_profesionales_especificas'),
                        'sdd210ds_a_competencias_unidad_curricular' =>Request::input('comp_unidad_curricular'),
                        'sdd210ds_a_valores_actitudes' =>Request::input('valores_actitudes'),
                        'sdd210ds_as_estrategias_didacticas' =>Request::input('estrategias_didacticas'),
                        'sdd210ds_as_estrategias_docentes' =>Request::input('estrategias_docentes'),
                        'sdd210ds_as_estrategias_aprendizajes' =>Request::input('estrategias_aprendizaje'),
                        'sdd210ds_as_bibliografia' =>Request::input('bibliografia'),
                        'sdd210ds_r_capacidades_profesionales' =>Request::input('capacidades_profesionales_tematica'),
                        'sdd210ds_r_capacidades' =>Request::input('capacidades'),
                        'sdd210ds_r_habilidades' =>Request::input('habilidades'),
                        'sdd210ds_r_red_tematica' =>Request::input('red_tematica'),
                        'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica')
                    ]
                    );

                // guardar datos 
                return redirect()->route('plan.mostrarasignados');

            }elseif($asignado->sdd200d_inferior_asignado == Auth::user()->cedula){
                
                if(!$asignado->sdd200d_superior_asignado || $asignado->sdd200d_superior_asignado ==''){
                    // si el superior no esta asignado quiere decir que lo envio directamente el jefe de departamento
                    // asi que se envia directo a su revision
                    $asignado->sdd200d_estado = 'rj';
                    $asignado->save();

                    // guardar datos

                    sdd210d::updateOrCreate(
                        [
                            'sdd210d_cod_carr' => $asignado->sdd200d_cod_carr,
                            'sdd210d_cod_asign' =>  $asignado->sdd200d_cod_asign,
                            'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia
                        ],
                        [
                            'sdd210ds_as_proposito' =>Request::input('proposito'),
                            'sdd210ds_as_competencias_genericas' =>Request::input('comp_genericas'),
                            'sdd210ds_a_competencias_profesionales' =>Request::input('comp_profesionales'),
                            'sdd210ds_s_competencias_profesionales_basicas' =>Request::input('comp_profesionales_basicas'),
                            'sdd210ds_s_competencias_profesionales_especificas' =>Request::input('comp_profesionales_especificas'),
                            'sdd210ds_a_competencias_unidad_curricular' =>Request::input('comp_unidad_curricular'),
                            'sdd210ds_a_valores_actitudes' =>Request::input('valores_actitudes'),
                            'sdd210ds_as_estrategias_didacticas' =>Request::input('estrategias_didacticas'),
                            'sdd210ds_as_estrategias_docentes' =>Request::input('estrategias_docentes'),
                            'sdd210ds_as_estrategias_aprendizajes' =>Request::input('estrategias_aprendizaje'),
                            'sdd210ds_as_bibliografia' =>Request::input('bibliografia'),
                            'sdd210ds_r_capacidades_profesionales' =>Request::input('capacidades_profesionales_tematica'),
                            'sdd210ds_r_capacidades' =>Request::input('capacidades'),
                            'sdd210ds_r_habilidades' =>Request::input('habilidades'),
                            'sdd210ds_r_red_tematica' =>Request::input('red_tematica'),
                            'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica')
                        ]
                        );
                    return redirect()->route('plan.mostrarasignados');

                }else{
                    // si el superior esta asignado se reenvia al superior
                    $asignado->sdd200d_estado = 'rs';
                    $asignado->save();


                    //guardar datos
                    sdd210d::updateOrCreate(
                        [
                            'sdd210d_cod_carr' => $asignado->sdd200d_cod_carr,
                            'sdd210d_cod_asign' =>  $asignado->sdd200d_cod_asign,
                            'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia
                        ],
                        [
                            'sdd210ds_as_proposito' =>Request::input('proposito'),
                            'sdd210ds_as_competencias_genericas' =>Request::input('comp_genericas'),
                            'sdd210ds_a_competencias_profesionales' =>Request::input('comp_profesionales'),
                            'sdd210ds_s_competencias_profesionales_basicas' =>Request::input('comp_profesionales_basicas'),
                            'sdd210ds_s_competencias_profesionales_especificas' =>Request::input('comp_profesionales_especificas'),
                            'sdd210ds_a_competencias_unidad_curricular' =>Request::input('comp_unidad_curricular'),
                            'sdd210ds_a_valores_actitudes' =>Request::input('valores_actitudes'),
                            'sdd210ds_as_estrategias_didacticas' =>Request::input('estrategias_didacticas'),
                            'sdd210ds_as_estrategias_docentes' =>Request::input('estrategias_docentes'),
                            'sdd210ds_as_estrategias_aprendizajes' =>Request::input('estrategias_aprendizaje'),
                            'sdd210ds_as_bibliografia' =>Request::input('bibliografia'),
                            'sdd210ds_r_capacidades_profesionales' =>Request::input('capacidades_profesionales_tematica'),
                            'sdd210ds_r_capacidades' =>Request::input('capacidades'),
                            'sdd210ds_r_habilidades' =>Request::input('habilidades'),
                            'sdd210ds_r_red_tematica' =>Request::input('red_tematica'),
                            'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica')
                        ]
                        );
                    return redirect()->route('plan.mostrarasignados');
                }

            }
        }elseif(Auth::user()->hasRole('administrador')){
            // se revisa si tiene estado
            $estado = App\Models\sdd200d::where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();
            // si tiene estado rj o c o ff esta en su estado de aprobacion final, por lo que se actualiza
            if( isset($estado->sdd200d_estado) && ($estado->sdd200d_estado == 'rj' || $estado->sdd200d_estado == 'c ' || $estado->sdd200d_estado == 'ff')){
                $estado->sdd200d_estado ='ff';
                $estado->save();
                //guardar datos
                sdd210d::updateOrCreate(
                    [
                        'sdd210d_cod_carr' => $estado->sdd200d_cod_carr,
                        'sdd210d_cod_asign' =>  $estado->sdd200d_cod_asign,
                        'sdd210d_lapso_vigencia' =>  $estado->sdd200d_lapso_vigencia
                    ],
                    [
                        'sdd210ds_as_proposito' =>Request::input('proposito'),
                        'sdd210ds_as_competencias_genericas' =>Request::input('comp_genericas'),
                        'sdd210ds_a_competencias_profesionales' =>Request::input('comp_profesionales'),
                        'sdd210ds_s_competencias_profesionales_basicas' =>Request::input('comp_profesionales_basicas'),
                        'sdd210ds_s_competencias_profesionales_especificas' =>Request::input('comp_profesionales_especificas'),
                        'sdd210ds_a_competencias_unidad_curricular' =>Request::input('comp_unidad_curricular'),
                        'sdd210ds_a_valores_actitudes' =>Request::input('valores_actitudes'),
                        'sdd210ds_as_estrategias_didacticas' =>Request::input('estrategias_didacticas'),
                        'sdd210ds_as_estrategias_docentes' =>Request::input('estrategias_docentes'),
                        'sdd210ds_as_estrategias_aprendizajes' =>Request::input('estrategias_aprendizaje'),
                        'sdd210ds_as_bibliografia' =>Request::input('bibliografia'),
                        'sdd210ds_r_capacidades_profesionales' =>Request::input('capacidades_profesionales_tematica'),
                        'sdd210ds_r_capacidades' =>Request::input('capacidades'),
                        'sdd210ds_r_habilidades' =>Request::input('habilidades'),
                        'sdd210ds_r_red_tematica' =>Request::input('red_tematica'),
                        'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica')
                    ]
                );

            }else{
                // si no tiene estado es creado por el administrador
                // si el usuario no es el asignado pero es el administrador se actualiza o se crea
                $asignacion = sdd200d::updateOrCreate(
                    [
                        'sdd200d_plan_asignatura_id' => (int)$existeasignatura->id,
                        'sdd200d_cod_asign'=> $existeasignatura->sdd090d_cod_asign,
                        'sdd200d_lapso_vigencia' => $existeasignatura->sdd090d_lapso_vigencia,
                        'sdd200d_cod_carr' =>$existeasignatura->sdd090d_cod_carr,
                        
                    ],
                    [
                        'sdd200d_nom_asign' => $existeasignatura->sdd090d_nom_asign,
                        'sdd200d_inferior_asignado' => '',
                        'sdd200d_superior_asignado' => '',
                        'sdd200d_estado' => 'c',
                ]);

                // error_log('p');
                // error_log(json_encode($asignado));
                sdd210d::updateOrCreate(
                [
                    'sdd210d_cod_carr' => $existeasignatura->sdd090d_cod_carr,
                    'sdd210d_cod_asign' =>  $existeasignatura->sdd090d_cod_asign,
                    'sdd210d_lapso_vigencia' =>  $existeasignatura->sdd090d_lapso_vigencia
                ],
                [
                    'sdd210ds_as_proposito' =>Request::input('proposito'),
                    'sdd210ds_as_competencias_genericas' =>Request::input('comp_genericas'),
                    'sdd210ds_a_competencias_profesionales' =>Request::input('comp_profesionales'),
                    'sdd210ds_s_competencias_profesionales_basicas' =>Request::input('comp_profesionales_basicas'),
                    'sdd210ds_s_competencias_profesionales_especificas' =>Request::input('comp_profesionales_especificas'),
                    'sdd210ds_a_competencias_unidad_curricular' =>Request::input('comp_unidad_curricular'),
                    'sdd210ds_a_valores_actitudes' =>Request::input('valores_actitudes'),
                    'sdd210ds_as_estrategias_didacticas' =>Request::input('estrategias_didacticas'),
                    'sdd210ds_as_estrategias_docentes' =>Request::input('estrategias_docentes'),
                    'sdd210ds_as_estrategias_aprendizajes' =>Request::input('estrategias_aprendizaje'),
                    'sdd210ds_as_bibliografia' =>Request::input('bibliografia'),
                    'sdd210ds_r_capacidades_profesionales' =>Request::input('capacidades_profesionales_tematica'),
                    'sdd210ds_r_capacidades' =>Request::input('capacidades'),
                    'sdd210ds_r_habilidades' =>Request::input('habilidades'),
                    'sdd210ds_r_red_tematica' =>Request::input('red_tematica'),
                    'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica')
                ]
                );
            }

            
        }

        
    }else{
        //error, asignatura no existe
    }
    

    if(Auth::user()->hasRole('administrador')){
        return redirect()->route('general.listarasignaturaslapsocarrera', ["carrera"=>$carrera, "lapso"=>$lapso]);
    }
    return redirect()->route('plan.mostrarasignados');
})->middleware(['auth'])->name('general.plancrear');


Route::get('/{lapso}/{carrera}/{asignatura}/crearVersion', function(Request $request, $lapso, $carrera, $asignatura){
    //nombre de la asignatura
    $asignatura = DB::table('sdd090ds')->select('sdd090ds.sdd090d_nom_asign')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    //nombre de la carrera
    $carrera = DB::table('sdd080ds')->select('sdd080ds.sdd080d_nom_carr')->where('sdd080ds.sdd080d_cod_carr', '=', $carrera)->get()->first();

    if($asignatura && $carrera){
        return view('general.crearnuevaversionplan')->with(compact('asignatura','carrera'));
    }else{
        abort(403, 'No existe esta pagina');
    }
    
})->middleware(['auth','role:administrador'])->name('general.crearnuevaversionplan');

Route::post('/{lapso}/{carrera}/{asignatura}/crearVersion', function(Request $request, $lapso, $carrera, $asignatura){
    //nombre de la asignatura
    $asignaturaRes = DB::table('sdd090ds')->select('sdd090ds.sdd090d_nom_asign')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    //nombre de la carrera
    $carreraRes = DB::table('sdd080ds')->select('sdd080ds.sdd080d_nom_carr')->where('sdd080ds.sdd080d_cod_carr', '=', $carrera)->get()->first();

    if($asignaturaRes && $carreraRes){
        // busca versiones existentes y seleccionamos la mas alta
        $versionMasAlta = DB::table('sdd210ds')->select('sdd210ds.sdd210ds_version')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->orderBy('sdd210ds.sdd210ds_version', 'DESC')->get()->first();
        error_log(json_encode($versionMasAlta));
        error_log($lapso);
        
        if($versionMasAlta){
            // si el query devuelve un resultado se crea la nueva version

            // se convierta numero
            $version = (int)$versionMasAlta->sdd210ds_version;
            // se le suma uno para obtener la nueva version
            $version = ++$version;
            error_log($version);

            // se crea una nueva version 
            sdd210d::create(['sdd210ds_version'=>$version, 'sdd210d_lapso_vigencia'=>$lapso, 'sdd210d_cod_carr'=>$carrera, 'sdd210d_cod_asign'=>$asignatura]);
        }else{
            // se crea una version
            sdd210d::create(['sdd210ds_version'=>1, 'sdd210d_lapso_vigencia'=>$lapso, 'sdd210d_cod_carr'=>$carrera, 'sdd210d_cod_asign'=>$asignatura]);
        }
        
        return redirect()->route('general.listarasignaturaslapsocarrera', ['lapso' => $lapso, 'carrera' => $carrera]);
    }else{
        abort(403, 'No existe esta pagina');
    }
    
})->middleware(['auth','role:administrador'])->name('general.crearnuevaversionplan');


Route::get('/asignar', function(Request $request){
    $input = Request::all();
    error_log(json_encode($input));
});

Route::get('/check', function(Request $request){
    // $input = $request->all();
    $input = Request::all();
    $json = json_encode($input);
    error_log(implode(Request::input('invitee')));
    // error_log($json->nombre);
    // error_log($json->nombre);


    error_log('no tiene');

    return view('dashboard');
});

//PLANES
//listar planes
Route::get('/plan/lista', function(){
    $planes = App\Models\sdd100d::all();

    $planes = DB::table('sdd100ds')->select('*')->join('sdd080ds', 'sdd080ds.sdd080d_cod_carr','=','sdd100ds.sdd100d_cod_carr')->orderBy('sdd100ds.sdd100d_cod_carr', 'asc')->orderBy('sdd100ds.sdd100d_lapso', 'desc')->get();
    error_log($planes);
    return view('general.listarplanes')->with('planes',$planes);

})->middleware(['auth','role:administrador'])->name('general.listarplanes');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
