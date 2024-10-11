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
use App\Models\sdd215d;
use App\Models\sdd095d;
use App\Models\sdd110d;

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
})->name('general.crearplan')->middleware(['auth']);

Route::get('/plan/asignarplan', function () {
    $users = App\Models\User::all();
    error_log($users);
    return view('general.asignarplan')->with('users', $users);
})->name('general.asignarplan')->middleware(['auth','role:administrador']);

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

        // se busca si ya existen otras versiones del plan, y de ser asi se asigna la ultima version disponible
        
        foreach ($selresults as $asignatura){
            $ultimaVersion = DB::table('sdd210ds')->select('sdd210ds_version')->where('sdd210d_lapso_vigencia','    =',$asignatura->sdd090d_lapso_vigencia)->where('sdd210d_cod_carr', '=', $asignatura->sdd090d_cod_carr)->where('sdd210d_cod_asign','=',$asignatura->sdd090d_cod_asign)->orderBy('sdd210ds_version', 'desc')->get()->first();
            if($ultimaVersion){
                // si tiene una version existente se le asigna la ultima
                $versionActual = (int)$ultimaVersion->sdd210ds_version;
                $asignacion = sdd200d::updateOrCreate(
                    [
                        'sdd200d_plan_asignatura_id' => (int)$asignatura->id,
                        'sdd200d_cod_asign'=> $asignatura->sdd090d_cod_asign,
                        'sdd200d_nom_asign'=> $asignatura->sdd090d_nom_asign,
                        'sdd200d_cod_carr'=> $asignatura->sdd090d_cod_carr,
                        'sdd200d_lapso_vigencia' => $asignatura->sdd090d_lapso_vigencia,
                        'sdd200d_version' => $versionActual
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

            }else{
                // si no existen versiones previas por defecto se crea y se asigna la 1
                $asignacion = sdd200d::updateOrCreate(
                    [
                        'sdd200d_plan_asignatura_id' => (int)$asignatura->id,
                        'sdd200d_cod_asign'=> $asignatura->sdd090d_cod_asign,
                        'sdd200d_nom_asign'=> $asignatura->sdd090d_nom_asign,
                        'sdd200d_cod_carr'=> $asignatura->sdd090d_cod_carr,
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

    $asignaturas = DB::table('sdd090ds')->distinct()->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado', 'sdd210ds_version', 'sdd210ds_estado','sdd110d_semestre')->leftjoin('sdd200ds', function($join){
        $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    })->leftjoin('sdd210ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
    })
    ->leftjoin('sdd110ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
        
    })
    ->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)
    ->orderBy('sdd110d_semestre')
    // ->orderByRaw('CASE WHEN "sdd110d_semestre" = '."0".' THEN '.'"asdf"'.' ELSE "sdd110d_semestre" END DESC, "sdd110d_semestre" ASC')
    ->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd210ds_version', 'ASC')
    ->get();
    
    
    // error_log(json_encode(DB::table('sdd090ds')->distinct()->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado', 'sdd210ds_version', 'sdd210ds_estado','sdd110d_semestre')->leftjoin('sdd200ds', function($join){
    //     $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    // })->leftjoin('sdd210ds', function($join) use ($carrera, $lapso){
    //     $join->on(function($query) use($carrera, $lapso) {
    //         $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
    //         $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
    //         $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');

    //         //
    //         // $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd200ds.sdd200d_cod_carr');
    //         // $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd200ds.sdd200d_lapso_vigencia');
    //         // $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd200ds.sdd200d_cod_asign');
    //         // $query->on('sdd210ds.sdd210ds_version', '=', 'sdd200ds.sdd200d_version');
    //     });
    // })->leftjoin('sdd110ds', function($join) use ($carrera, $lapso){
    //     $join->on(function($query) use($carrera, $lapso) {
    //         $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
    //         $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
    //         $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
    //     });
        
    // })
    // ->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd210ds_version', 'ASC')->get()->first()));


    error_log(
            DB::table('sdd090ds')->distinct()->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado', 'sdd210ds_version', 'sdd210ds_estado','sdd110d_semestre')->leftjoin('sdd200ds', function($join){
                $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
            })->leftjoin('sdd210ds', function($join) use ($carrera, $lapso){
                $join->on(function($query) use($carrera, $lapso) {
                    $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
                    $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
                    $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
                    $query->on('sdd210ds.sdd210ds_version', '=', 1);
                });
            })
            ->leftjoin('sdd110ds', function($join) use ($carrera, $lapso){
                $join->on(function($query) use($carrera, $lapso) {
                    $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
                    $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
                    $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
                });
                
            })
            ->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)
            ->orderBy('sdd110d_semestre')
            // ->orderByRaw('CASE WHEN "sdd110d_semestre" = '."0".' THEN '.'"asdf"'.' ELSE "sdd110d_semestre" END DESC, "sdd110d_semestre" ASC')
            ->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd210ds_version', 'ASC')
            ->toSql()
        
        );

    // error_log(json_encode($asignaturas[0]));
    // error_log(DB::table('sdd090ds')->select('sdd200ds.id as status_id','*')->leftjoin('sdd200ds', function($join){
    //     $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    // })->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->toSql());


    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();
    
    // return view('general.listarasignaturasplancarrera')->with('asignaturas',$asignaturas);
    return view('general.listarasignaturasplancarrera',compact('asignaturas', 'carrera', 'lapso'));
})->middleware(['auth'])->name('general.listarasignaturaslapsocarrera');

//Relacion de asignaturas
Route::get('/{lapso}/{carrera}/relacion/crear', function(Request $reques,$lapso,$carrera){
    // se listan las asignaturas para relacionar
    $relacion = DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->get();
    $asignaturas = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->get();
    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();
    
    error_log(DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->toSql());
    error_log(json_encode($relacion));
    error_log($lapso);
    error_log($carrera);
    return view('asignaturas.relacionarasignaturas',compact('asignaturas', 'carrera', 'lapso', 'relacion'));
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionarasignaturas');

//Relacion de asignaturas post
Route::post('/{lapso}/{carrera}/relacion/crearr', function(\Illuminate\Http\Request $reques, $lapso, $carrera){
    // aqui se reciben los datos de las asignaturas relacioandas desde el front y se envia una respuesta

    // error_log('alo');
    error_log(Request::input('alo'));
    // error_log(json_encode($reques::all()));
    // error_log(json_encode($reques->all()));
    error_log(json_encode(Request::all()));
    error_log(json_encode(Request::input('data')));

    $datarelacion = json_decode(Request::input('data'));

    error_log(json_encode($datarelacion[0]));
    error_log(json_encode($datarelacion[0]->asignatura));
    error_log(json_encode($datarelacion[0]->relacion));
    error_log(count($datarelacion[0]->relacion));


    //despues se crean los nuevos
    // sdd095d::updateOrCreate(
    //     [
    //         'sdd095_lapso_vigencia'
    //         'sdd095_cod_carr', 
    //         'sdd095_cod_asign'
    //     ]
    // )

    try{
        //primero se eliminan los viejos valores de temas relacionados
        DB::table('sdd095ds')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->delete();
        
        //se asignan los nuevos temas
        for($i = 0 ; $i < count($datarelacion); $i++){
            if(count($datarelacion[$i]->relacion) <= 0){
                
                continue;
            }elseif(count($datarelacion[$i]->relacion) == 1){


                DB::table('sdd095ds')->insert([
                    'sdd095_lapso_vigencia' => $lapso,
                    'sdd095_cod_carr' => $carrera, 
                    'sdd095_cod_asign' => $datarelacion[$i]->asignatura,
                    'sdd095_nom_asignatura' => $datarelacion[$i]->nombre,
                    'sdd095_asignatura_relacion_cod' => $datarelacion[$i]->relacion[0]->id,
                    'sdd095_asignatura_relacion_nombre' => $datarelacion[$i]->relacion[0]->nombre
                ]);
            }else{
                for($j=0; $j < count($datarelacion[$i]->relacion) ; $j++){
                    DB::table('sdd095ds')->insert([
                        'sdd095_lapso_vigencia' => $lapso,
                        'sdd095_cod_carr' => $carrera, 
                        'sdd095_cod_asign' => $datarelacion[$i]->asignatura,
                        'sdd095_nom_asignatura' => $datarelacion[$i]->nombre,
                        'sdd095_asignatura_relacion_cod' => $datarelacion[$i]->relacion[$j]->id,
                        'sdd095_asignatura_relacion_nombre' => $datarelacion[$i]->relacion[$j]->nombre
                    ]);
                }
            }

            error_log(json_encode($datarelacion[$i]->relacion));
        }
    }catch (Exception $e){
        return response()->json(array('msg'=> 'Error al insertar'), 400);
    }

    

    //aqui

    return response()->json(array('msg'=> 'insertado exitosamente'), 200);
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionarasignaturass');


//Creacion-detalle planes
Route::get('/{lapso}/{carrera}/{asignatura}/crear', function(Request $request,$lapso,$carrera,$asignatura){
    error_log(Auth::user()->hasRole('administrador'));

    // se verifica que la asignatura exista y se obtiene su informacion
    $asignaturaDetalle = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    $semestre = sdd110d::where('sdd110d_lapso_vigencia', '=', $lapso)->where('sdd110d_cod_carr', '=', $carrera)->where('sdd110d_cod_asign', $asignatura)->first();
    if(!$asignaturaDetalle){
        // di no existe la asignatura se retorna un error
        abort(403, 'No existe esta pagina');
    }


    // se revisa que existe en la tabla detalle de plan
    $existeplan = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->orderBy('sdd210ds.sdd210ds_version', 'desc')->get()->first();

    if($existeplan){
        // si existe un plan se manda a la vista editar
        return redirect()->route('general.planeditar', ['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura, 'version'=>$existeplan->sdd210ds_version]);
    }

    // si es administrador puede ver cualquier pagina
    if(Auth::user()->hasRole('administrador')){
        
        return view('general.cargaplandetalle')->with('asignatura', $asignaturaDetalle)->with('semestre',$semestre);
    }else{
        // Revisa que el usuario con la sesion activa este asignado
        // limitar a que vea solo a la que esta asignado
        $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
        
        //si no esta asignado retorna error
        if(count($asignados) ==0){
            if($existeplan){
                return redirect()->route('general.planver', ['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura, 'version'=>$existeplan->sdd210ds_version]);
            }
            
            abort(403, 'No tienes permiso para ver esta pagina');
        }else{
            return view('general.cargaplandetalle')->with('asignatura', $asignaturaDetalle)->with('semestre',$semestre);
        }
    }
    
})->middleware(['auth'])->name('general.plancrear');

//old
Route::get('/{lapso}/{carrera}/{asignatura}/{version}/editar', function(Request $request,$lapso,$carrera,$asignatura,$version){
    error_log(Auth::user()->hasRole('administrador'));

    $asignaturaDetalle = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    $semestre = sdd110d::where('sdd110d_lapso_vigencia', '=', $lapso)->where('sdd110d_cod_carr', '=', $carrera)->where('sdd110d_cod_asign', $asignatura)->first();
    
    if(!$asignaturaDetalle){
        // si no existe la asignatura se retorna un error
        abort(403, 'No existe esta pagina');
    }

    //se obtienen los temas de esta asignatura


    // se revisa que existe en la tabla detalle de plan
    $plan = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->where('sdd210ds.sdd210ds_version', '=', $version)->orderBy('sdd210ds.sdd210ds_version', 'desc')->get()->first();
    error_log(json_encode($plan));
    if(!$plan){
        // si no existe un plan se manda a la vista crear
        return redirect()->route('general.plancrear',['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura]);
    }

    $estado = DB::table('sdd200ds')->select('sdd200d_estado')->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();

    // si es administrador puede ver cualquier pagina
    if(Auth::user()->hasRole('administrador')){

        // se obtienen los temas
        $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->get();
        error_log('alo');
        error_log(json_encode($temas));
        return view('general.cargaplandetalleeditar')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado','temas'))->with('semestre',$semestre);
    }else{
        // Revisa que el usuario con la sesion activa este asignado
        // limitar a que vea solo a la que esta asignado
        $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
        
        //si no esta asignado retorna error
        if(count($asignados) ==0){
            if($plan){
                return redirect()->route('general.planver', ['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura, 'version'=>$plan->sdd210ds_version]);
            }
            abort(403, 'No tienes permiso para ver esta pagina');
        }else{
            error_log('alo2');
            $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->get();
            error_log(json_encode($temas));
            return view('general.cargaplandetalleeditar')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado', 'temas'))->with('semestre',$semestre);
        }
    }
})->middleware(['auth'])->name('general.planeditar');

// cargar datos del plan
Route::post('/{lapso}/{carrera}/{asignatura}/crear', function(Request $request,$lapso,$carrera,$asignatura){

    // error_log(json_encode(Request::all()));
    // error_log(json_encode(Request::input('temario')));
    $temario = Request::input('temario');
    error_log(Auth::id());

    foreach($temario as $tema){
        error_log(json_encode($tema));
        error_log($tema['nombre']);
        sdd215d::updateOrCreate([
            'sdd215d_cod_carr' => $carrera,
            'sdd215d_cod_asign' => $asignatura,
            'sdd215d_lapso_vigencia' => $lapso,
            'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
        ], [
            // 'sdd215d_version' => 1,
        
            
            'sdd215ds_nombre_tema' => $tema['nombre'],
            'sdd215ds_contenido_tema' => $tema['contenido'],
            'sdd215ds_profesor_creador' => Auth::id()
        ]);
    }

    
    // // update or create state 

    //se verifica que la asignatura exista
    $existeasignatura=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->where('sdd090d_cod_asign', $asignatura)->first();
    // se revisa que el usuario este asignado a la asignatura, ya sea como superior o inferior
    // $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
    $asignado = App\Models\sdd200d::where('sdd200d_lapso_vigencia','=',$lapso)->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', $asignatura)->where(function ($query){
        $query->where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula);
    })->first();

    
    // si existe la asignatura
    if($existeasignatura){
        // se obtiene la ultima version de la asignatura, siempre se actualiza la ultima version
        $ultimaVersion = DB::table('sdd210ds')->select('sdd210ds_version')->where('sdd210d_lapso_vigencia','=',$lapso)->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', $asignatura)->orderBy('sdd210ds_version', 'desc')->get()->first();
        $version = 1;
        if($ultimaVersion){
            $version = $ultimaVersion->sdd210ds_version;
        }
        // si el usuario con la sesion activa esta asignado se actualiza el estado
        if($asignado){
            if($asignado->sdd200d_superior_asignado == Auth::user()->cedula){
                // si es el superior se envia al jefe de departamento
                $asignado->sdd200d_estado = 'rj';
                $asignado->save();

                // se guardan los temas
                foreach($temario as $tema){
                    error_log(json_encode($tema));
                    error_log($tema['nombre']);
                    sdd215d::updateOrCreate([
                        'sdd215d_cod_carr' => $carrera,
                        'sdd215d_cod_asign' => $asignatura,
                        'sdd215d_lapso_vigencia' => $lapso,
                        'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
                    ], [
                        // 'sdd215d_version' => 1,
                    
                        
                        'sdd215ds_nombre_tema' => $tema['nombre'],
                        'sdd215ds_contenido_tema' => $tema['contenido'],
                        'sdd215ds_profesor_creador' => Auth::id()
                    ]);
                }

                sdd210d::updateOrCreate(
                    [
                        'sdd210d_cod_carr' => $asignado->sdd200d_cod_carr,
                        'sdd210d_cod_asign' =>  $asignado->sdd200d_cod_asign,
                        'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia,
                        'sdd210ds_version' => $version
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
                        'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                        'sdd210ds_estado' => 'rj'
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
                            'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia,
                            'sdd210ds_version' => $version
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
                            'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                            'sdd210ds_estado' => 'rj'
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
                            'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia,
                            'sdd210ds_version' => $version
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
                            'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                            'sdd210ds_estado' => 'rs'
                        ]
                        );
                    return redirect()->route('plan.mostrarasignados');
                }

            }
        }elseif(Auth::user()->hasRole('administrador')){
            // se guardan los temas
            foreach($temario as $tema){
                error_log(json_encode($tema));
                error_log($tema['nombre']);
                sdd215d::updateOrCreate([
                    'sdd215d_cod_carr' => $carrera,
                    'sdd215d_cod_asign' => $asignatura,
                    'sdd215d_lapso_vigencia' => $lapso,
                    'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
                ], [
                    // 'sdd215d_version' => 1,
                
                    
                    'sdd215ds_nombre_tema' => $tema['nombre'],
                    'sdd215ds_contenido_tema' => $tema['contenido'],
                    'sdd215ds_profesor_creador' => Auth::id()
                ]);
            }
            // se revisa si tiene estado
            $estado = App\Models\sdd200d::where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();
            // si tiene estado rj o c o ff esta en su estado de aprobacion final, por lo que se actualiza
            if( isset($estado->sdd200d_estado) && ($estado->sdd200d_estado == 'rj' || $estado->sdd200d_estado == 'c ' || $estado->sdd200d_estado == 'ff')){
                // $estado->sdd200d_estado ='ff';
                // $estado->save();

                // se elimina el estado ya que esta completo, ya no tiene a nadie asignado
                $estado->delete();

                // se actualizan los estados de los planes viejos
                sdd210d::where('sdd210ds_estado','=','a')->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', '=', $asignatura)->where('sdd210d_lapso_vigencia', '=',$lapso)->update(['sdd210ds_estado'=>'v']);

                //guardar datos
                sdd210d::updateOrCreate(
                    [
                        'sdd210d_cod_carr' => $estado->sdd200d_cod_carr,
                        'sdd210d_cod_asign' =>  $estado->sdd200d_cod_asign,
                        'sdd210d_lapso_vigencia' =>  $estado->sdd200d_lapso_vigencia,
                        'sdd210ds_version' => $version,
                        
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
                        'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                        'sdd210ds_estado' => 'a'
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
                        'sdd200d_version' => $version
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
                    'sdd210d_lapso_vigencia' =>  $existeasignatura->sdd090d_lapso_vigencia,
                    'sdd210ds_version' => $version
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
                    'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                    'sdd210ds_estado' => 'c'
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
        $versionMasAlta = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->orderBy('sdd210ds.sdd210ds_version', 'DESC')->get()->first();
        error_log(json_encode($versionMasAlta));
        error_log($lapso);
        
        if($versionMasAlta){
            // si el query devuelve un resultado se crea la nueva version

            // se convierta numero
            $version = (int)$versionMasAlta->sdd210ds_version;
            // se le suma uno para obtener la nueva version
            $version = ++$version;
            error_log($version);

            $toreplicate = sdd210d::where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->orderBy('sdd210ds.sdd210ds_version', 'DESC')->get()->first();
            // se crea una nueva version con los mismos datos que el pasado
            $nuevo = $toreplicate->replicate();
            $nuevo->sdd210ds_estado ='nv';
            $nuevo->sdd210ds_version = $version;
            $nuevo->save();
            // sdd210d::create(['sdd210ds_version'=>$version, 'sdd210d_lapso_vigencia'=>$lapso, 'sdd210d_cod_carr'=>$carrera, 'sdd210d_cod_asign'=>$asignatura]);
        }else{
            // se crea una version
            sdd210d::create(['sdd210ds_version'=>1, 'sdd210d_lapso_vigencia'=>$lapso, 'sdd210d_cod_carr'=>$carrera, 'sdd210d_cod_asign'=>$asignatura]);
        }
        
        return redirect()->route('general.listarasignaturaslapsocarrera', ['lapso' => $lapso, 'carrera' => $carrera]);
    }else{
        abort(403, 'No existe esta pagina');
    }
    
})->middleware(['auth','role:administrador'])->name('general.crearnuevaversionplan');

// ver plan
Route::get('/{lapso}/{carrera}/{asignatura}/{version}/ver', function(Request $request,$lapso,$carrera,$asignatura){
    error_log(Auth::user()->hasRole('administrador'));

    // se verifica que la asignatura exista y se obtiene su informacion
    $asignaturaDetalle = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    $semestre = sdd110d::where('sdd110d_lapso_vigencia', '=', $lapso)->where('sdd110d_cod_carr', '=', $carrera)->where('sdd110d_cod_asign', $asignatura)->first();
    $estado = DB::table('sdd200ds')->select('sdd200d_estado')->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();
    if(!$asignaturaDetalle){
        // di no existe la asignatura se retorna un error
        abort(403, 'No existe esta pagina');
    }


    // se revisa que existe en la tabla detalle de plan
    $plan = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->orderBy('sdd210ds.sdd210ds_version', 'desc')->get()->first();

    if($plan){
        error_log(json_encode($plan));
        $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->get();
        // si existe un plan se manda a la vista editar
        return view('general.plandetallever')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado','temas'))->with('semestre',$semestre);
    }else{
        abort(403, 'No disponible');
    }

    
})->middleware(['auth'])->name('general.planver');


Route::get('/{lapso}/{carrera}/relacionartemas', function(Request $request, $lapso, $carrera){
    // sdd215d::select('*');

    $temasrelacionados = DB::table('sdd216ds')->select('*')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->get();

    //todos los temas de esta carrera en este lapso
    $temas = DB::table('sdd215ds')->select('*')->where('sdd215ds.sdd215d_lapso_vigencia', '=', $lapso)->where('sdd215ds.sdd215d_cod_carr', '=', $carrera)->orderBy('sdd215ds.created_at')->get();

    // todas las asignaturas de esta carrera en este lapso
    $asignaturas = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->get();

    // las asignaturas relacionadas
    // DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->get();
    $asignaturasrelacionadas =DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->get();

    // los datos de la carrera
    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();

    return view('asignaturas.relacionartemaasignaturas')->with(compact('temas', 'asignaturas', 'carrera', 'lapso', 'asignaturasrelacionadas', 'temasrelacionados'));
    
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionartemas');

Route::post('/{lapso}/{carrera}/relacionartemas', function(Request $request, $lapso, $carrera){

    $datarelacion = json_decode(Request::input('data'));
    $resetear = json_decode(Request::input('resetear'));
    error_log(json_encode($datarelacion));
    if(isset($resetear) ){
        if($resetear == 1){
            DB::table('sdd216ds')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->delete();
            return response()->json(array('msg'=> 'eliminado exitosamente'), 200);
        }
        
    }else{
        error_log(json_encode($datarelacion));
        try{
            //primero se eliminan los viejos valores de temas relacionados
            DB::table('sdd216ds')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->delete();
            for($i = 0 ; $i < count($datarelacion); $i++){
                error_log('i'.$i.'   '.count($datarelacion) );
                for($j = 0 ; $j < count($datarelacion[$i]->relaciones); $j++){
                    error_log('j'.$j. '   '. count($datarelacion[$i]->relaciones));
                    DB::table('sdd216ds')->insert([
                        "sdd216d_lapso_vigencia" => $lapso, 
                        "sdd216d_cod_carr" => $carrera, 
                        "sdd216d_cod_asign" => $datarelacion[$i]->asignaturaPadre, 
                        "sdd216d_cod_asign_relacion" => $datarelacion[$i]->relaciones[$j]->asignatura, 
                        "sdd216d_nom_asignatura" => $datarelacion[$i]->asignaturaPadreNombre, 
                        "sdd216d_nom_asignatura_relacion" => $datarelacion[$i]->relaciones[$j]->asignaturaNombre,
                        "sdd216d_id_tema_asignatura_principal" => $datarelacion[$i]->temaId, 
                        "sdd216d_nom_tema_asignatura_principal" => $datarelacion[$i]->temaPadreNombre, 
                        "sdd216d_id_tema_asignatura_relacion" => $datarelacion[$i]->relaciones[$j]->temaId, 
                        "sdd216d_nom_tema_asignatura_relacion" => $datarelacion[$i]->relaciones[$j]->temaNombre
                    ]);
                }
                
            }
            
            
            //se asignan los nuevos temas
        }catch (Exception $e){
            error_log(json_encode($e));
            return response()->json(array('msg'=> 'Error al insertar '.$e), 400);
            
        }

        error_log('here');
        return response()->json(array('msg'=> 'insertado exitosamente'), 200);
    }
    
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionartemas');






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

Route::get('/administrador/coordinadores', function(){
    $carreras = App\Models\sdd080d::all();
    $coordinadores = DB::table('sdd900ds')->select('*')->get();
    error_log($coordinadores);
    return view('general.coordinadores')->with('coordinadores',$coordinadores)->with('carreras', $carreras);

})->middleware(['auth','role:administrador'])->name('general.editarcoordinadores');



//RELACIONAR ASIGNATURAS
// Route::get('/{lapso}/{carrera}/asignaturas/relacionar', function(Request $reques,$lapso,$carrera){
//     $asignaturas = DB::table('sdd090ds')->select('*')
// })->middleware(['auth','role:administrador'])->name('general.relacionarasignaturas');






// nuevas rutas 

//Asignaturas de una carrera filtradas por plan
Route::get('/{lapso}/{carrera}/{version}/asignaturas/lista', function(Request $reques,$lapso,$carrera,$version){
    $ver = (int)$version;

    $asignaturas = DB::table('sdd090ds')->distinct()->select('sdd090d_cod_carr', 'sdd090d_cod_asign', 'sdd090ds.id as id', 'sdd090d_nom_asign', 'sdd090d_uc', 'sdd200d_inferior_asignado','sdd090d_nivel_asignatura', 'sdd200d_superior_asignado','sdd200d_estado', 'sdd210ds_version', 'sdd210ds_estado','sdd110d_semestre')->leftjoin('sdd200ds', function($join){
        $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    })->leftjoin('sdd210ds', function($join) use ($carrera, $lapso,$ver){
        $join->on(function($query) use($carrera, $lapso,$ver) {
            $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
            // $query->on('sdd210ds.sdd210ds_version', '=', 1);
            $query->on(DB::raw('sdd210ds.sdd210ds_version'), DB::raw($ver));
        });
    })
    ->leftjoin('sdd110ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
        
    })
    ->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)
    ->orderBy('sdd110d_semestre')
    // ->orderByRaw('CASE WHEN "sdd110d_semestre" = '."0".' THEN '.'"asdf"'.' ELSE "sdd110d_semestre" END DESC, "sdd110d_semestre" ASC')
    ->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd210ds_version', 'ASC')
    ->get();

    

    $versiones = DB::table('sdd210ds')
    ->select('sdd210ds_version')
    ->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)
    ->groupBy('sdd210ds_version')
    ->orderBy('sdd210ds_version', 'ASC')->get();

    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();

    return view('general.listarasignaturasplancarrerav2',compact('asignaturas', 'carrera', 'lapso', 'versiones'));
})->middleware(['auth'])->name('general.listarasignaturaslapsocarrerav2');


Route::get('/plan/v2/asignarasignatura', function (Request $request) {
    //obtenemos los usuarios para la lista de las personas a las que se les puede asignar una asignatura
    $users = App\Models\User::whereNotNull('cedula')->get();
    
    error_log(json_encode(Request::input('asignatura')));

    //se seleccionan los parametros query en el link del buscador
    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    $seleccionadas = Request::input('asignatura');
    $version = Request::input('version');

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

    return view('general.asignarasignaturav2')->with('data',['users'=> $users, 'seleccionadas' => $seleccionadas, 'lapso'=>$lapso, 'carrera'=>$carrera, 'error'=>$error, 'version'=>$version])->with(compact('selresults'));
})->middleware(['auth','role:administrador','role:supervisor'])->name('general.asignarasignaturav2');


Route::post('/plan/v2/asignarasignatura', function (Request $request) {
    
    // error_log(Request::input('tipo_asignacion'));

    $tipo = Request::input('tipo_asignacion');
    $asignado = Request::input('asignado');
    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    $asignaturas = Request::input('asignaturas');
    $usuario = Request::input('user-plan');
    $version = Request::input('version');
    $indirecta = '';
    $directa = '';

    error_log('aqu'.$version);

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
        return view('general.asignarasignaturav2')->with('data',['error'=>$error]);
    }else{
        $selresults=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->whereIn('sdd090d_cod_asign', $asignaturas)->get();

        // se busca si ya existen otras versiones del plan, y de ser asi se asigna la ultima version disponible
        
        foreach ($selresults as $asignatura){
            error_log('v2 '. $version);
            
            $asignacion = sdd200d::updateOrCreate(
                [
                    'sdd200d_plan_asignatura_id' => (int)$asignatura->id,
                    'sdd200d_cod_asign'=> $asignatura->sdd090d_cod_asign,
                    'sdd200d_nom_asign'=> $asignatura->sdd090d_nom_asign,
                    'sdd200d_cod_carr'=> $asignatura->sdd090d_cod_carr,
                    'sdd200d_lapso_vigencia' => $asignatura->sdd090d_lapso_vigencia,
                    'sdd200d_version' => (int)$version
                ],
                [
                    // 'sdd200d_plan_asignatura_id' => (int)$asignatura->id,
                    // 'sdd200d_cod_carr' => $carrera,
                    // 'sdd200d_cod_asign'=> $asignatura->sdd090d_cod_asign,
                    // 'sdd200d_nom_asign'=> $asignatura->sdd090d_nom_asign,
                    // 'sdd200d_lapso_vigencia' => $asignatura->sdd090d_lapso_vigencia,
                    'sdd200d_inferior_asignado' => $indirecta,
                    'sdd200d_superior_asignado' => $directa,
                    'sdd200d_estado' => 'a',
                    // 'sdd200d_version' => (int)$version
            ]);
            
        }

        return redirect()->route('general.listarasignaturaslapsocarrerav2', ['lapso' => $lapso, 'carrera' => $carrera, 'version' => (int)$version]);
    }
})->middleware(['auth','role:administrador','role:supervisor'])->name('general.asignarasignaturapostv2');





Route::get('/{lapso}/{carrera}/{asignatura}/{version}/detalle', function(Request $request,$lapso,$carrera,$asignatura,$version){
    error_log(Auth::user()->hasRole('administrador'));

    $asignaturaDetalle = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->where('sdd090ds.sdd090d_cod_asign', '=', $asignatura)->get()->first();
    $semestre = sdd110d::where('sdd110d_lapso_vigencia', '=', $lapso)->where('sdd110d_cod_carr', '=', $carrera)->where('sdd110d_cod_asign', $asignatura)->first();
    
    if(!$asignaturaDetalle){
        // si no existe la asignatura se retorna un error
        abort(403, 'No existe esta pagina');
    }

    //se obtienen los temas de esta asignatura

    // se revisa que existe en la tabla detalle de plan
    $plan = DB::table('sdd210ds')->select('*')->where('sdd210ds.sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210ds.sdd210d_cod_carr', '=', $carrera)->where('sdd210ds.sdd210d_cod_asign', '=', $asignatura)->where('sdd210ds.sdd210ds_version', '=', $version)->orderBy('sdd210ds.sdd210ds_version', 'desc')->get()->first();
    // error_log(json_encode($plan));
    // if(!$plan){
    //     // si no existe un plan se manda a la vista crear
    //     // return redirect()->route('general.plancrear',['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura]);
    //     return redirect()->route('general.plancrear',['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura]);
    // }

    $versiones = DB::table('sdd210ds')->select('sdd210ds_version')->where('sdd210d_lapso_vigencia','=',$lapso)->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', $asignatura)->orderBy('sdd210ds_version', 'desc')->get();

    error_log(json_encode(count($versiones)));
    error_log(!isset($versiones));
    error_log((int)$version == 1);
    error_log(count($versiones) ==0 && (int)$version != 1);
    // si no hay versiones solo se puede crear la version 1 de la asignatura
    if ((!isset($versiones) && (int)$version != 1) ) {
        abort(403, 'Estas intentando crear una version superior a la que viene');
    }elseif((int)$version > count($versiones) + 1){
        abort(403, 'Estas intentando crear una version superior a la que viene');
    }

    

    $estado = DB::table('sdd200ds')->select('sdd200d_estado')->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();

    // si es administrador puede ver cualquier pagina
    if(Auth::user()->hasRole('administrador')){

        // se obtienen los temas
        $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->where('sdd215d_version', '=',(int)$version)->get();

        if(count($temas) == 0 && $version > 1){
            $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->where('sdd215d_version', '=',(int)$version -1)->get();
        }
        error_log('alo');
        error_log(json_encode($temas));
        return view('general.cargaplandetalleeditarv2')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado','temas'))->with('semestre',$semestre);
    }else{
        // Revisa que el usuario con la sesion activa este asignado
        // limitar a que vea solo a la que esta asignado
        // $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
        $asignados = App\Models\sdd200d::where(function ($query)  {
            $query->where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)
                  ->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula);
        })->where('sdd200d_version', '=', (int)$version)->where('sdd200d_cod_asign', '=', $asignatura)->get();
        error_log(json_encode($asignados));
        //si no esta asignado retorna error
        if(count($asignados) ==0){
            if($plan){
                return redirect()->route('general.planver', ['lapso'=> $lapso, 'carrera'=>$carrera, 'asignatura'=>$asignatura, 'version'=>$plan->sdd210ds_version]);
            }
            abort(403, 'No tienes permiso para ver esta pagina');
        }else{
            error_log('alo2');
            $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->where('sdd215d_version', '=',(int)$version)->get();
            if(count($temas) == 0 && $version > 1){
                $temas = DB::table('sdd215ds')->select('*')->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', '=', $asignatura)->where('sdd215d_lapso_vigencia', '=',$lapso)->where('sdd215d_version', '=',(int)$version -1)->get();
            }
            error_log(json_encode($temas));
            return view('general.cargaplandetalleeditarv2')->with('asignatura', $asignaturaDetalle)->with('plan', $plan)->with(compact('estado', 'temas'))->with('semestre',$semestre);
        }
    }
})->middleware(['auth'])->name('general.plandetalleeditar');


// cargar datos del plan
Route::post('/{lapso}/{carrera}/{asignatura}/{version}/crear', function(Request $request,$lapso,$carrera,$asignatura,$version){
    $version = (int)$version;
    // error_log(json_encode(Request::all()));
    // error_log(json_encode(Request::input('temario')));
    $temario = Request::input('temario');
    error_log(Auth::id());

    // if(isset($temario)){
    //     foreach($temario as $tema){
    //         error_log(json_encode($tema));
    //         error_log($tema['nombre']);
    //         sdd215d::updateOrCreate([
    //             'sdd215d_cod_carr' => $carrera,
    //             'sdd215d_cod_asign' => $asignatura,
    //             'sdd215d_lapso_vigencia' => $lapso,
    //             'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
    //         ], [
    //             // 'sdd215d_version' => 1,
            
                
    //             'sdd215ds_nombre_tema' => $tema['nombre'],
    //             'sdd215ds_contenido_tema' => $tema['contenido'],
    //             'sdd215ds_profesor_creador' => Auth::id()
    //         ]);
    //     }
    // }

    

    
    // // update or create state 

    //se verifica que la asignatura exista
    $existeasignatura=DB::table('sdd090ds')->where('sdd090d_lapso_vigencia','=',$lapso)->where('sdd090d_cod_carr', '=', $carrera)->where('sdd090d_cod_asign', $asignatura)->first();
    // se revisa que el usuario este asignado a la asignatura, ya sea como superior o inferior
    // $asignados = App\Models\sdd200d::where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula)->get();
    $asignado = App\Models\sdd200d::where('sdd200d_lapso_vigencia','=',$lapso)->where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', $asignatura)->where(function ($query){
        $query->where('sdd200d_inferior_asignado', '=', Auth::user()->cedula)->orWhere('sdd200d_superior_asignado', '=', Auth::user()->cedula);
    })->first();

    
    // si existe la asignatura
    if($existeasignatura){
        // se obtiene la ultima version de la asignatura, siempre se actualiza la ultima version
        // $ultimaVersion = DB::table('sdd210ds')->select('sdd210ds_version')->where('sdd210d_lapso_vigencia','=',$lapso)->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', $asignatura)->orderBy('sdd210ds_version', 'desc')->get()->first();
        // $version = 1;
        // if($ultimaVersion){
        //     $version = $ultimaVersion->sdd210ds_version;
        // }

        // se extraen los temas existentes para saber si se crearan desde 0, se actualizaran o si se eliminara el sobrante
        $temasexistentes = sdd215d::where('sdd215d_lapso_vigencia','=',$lapso)->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', $asignatura)->where('sdd215d_version', $version)->orderBy('sdd215d_version', 'ASC')->get();

        // se verifica que no se quiera crear una version mayor a la existente

        $versiones = DB::table('sdd210ds')->select('sdd210ds_version')->where('sdd210d_lapso_vigencia','=',$lapso)->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', $asignatura)->orderBy('sdd210ds_version', 'desc')->get();

        // si no hay versiones solo se puede crear la version 1 de la asignatura
        // if((count($versiones) ==0 && $version != 1) || ($version <= count($versiones) + 1)){
        //     abort(403, 'Estas intentando crear una version superior a la que viene');
        // }
        

        // si el usuario con la sesion activa esta asignado se actualiza el estado
        
        if($asignado){
            if($asignado->sdd200d_superior_asignado == Auth::user()->cedula){
                // si es el superior se envia al jefe de departamento
                $asignado->sdd200d_estado = 'rj';
                $asignado->save();

                // se guardan los temas
                if(isset($temario)){
                    foreach($temario as $tema){
                        error_log(json_encode($tema));
                        error_log($tema['nombre']);
                        sdd215d::updateOrCreate([
                            'sdd215d_cod_carr' => $carrera,
                            'sdd215d_cod_asign' => $asignatura,
                            'sdd215d_lapso_vigencia' => $lapso,
                            'sdd215d_version' => $version,
                            'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
                        ], [
                            // 'sdd215d_version' => 1,
                        
                            
                            'sdd215ds_nombre_tema' => $tema['nombre'],
                            'sdd215ds_contenido_tema' => $tema['contenido'],
                            'sdd215ds_profesor_creador' => Auth::id()
                        ]);
                    }

                    // si los temas cargados por el usuario son mayores a los temas q ya tiene la asginatura hay que eliminar el sobrante
                    if(count($temasexistentes)> 0 && ( count($temasexistentes) > count($temario))){
                        if(count($temasexistentes) > count($temario)){
                            for($i = count($temario) ; $i < count($temasexistentes) ; $i++){
                                sdd215d::where('id', $temasexistentes[$i]->id)->delete();
                            }
                        }
                    }
                }

                sdd210d::updateOrCreate(
                    [
                        'sdd210d_cod_carr' => $asignado->sdd200d_cod_carr,
                        'sdd210d_cod_asign' =>  $asignado->sdd200d_cod_asign,
                        'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia,
                        'sdd210ds_version' => $version
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
                        'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                        'sdd210ds_estado' => 'rj'
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
                            'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia,
                            'sdd210ds_version' => $version
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
                            'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                            'sdd210ds_estado' => 'rj'
                        ]
                        );

                    // se actualizan los temas 
                    // se guardan los temas
                    if(isset($temario)){
                        foreach($temario as $tema){
                            error_log(json_encode($tema));
                            error_log($tema['nombre']);
                            sdd215d::updateOrCreate([
                                'sdd215d_cod_carr' => $carrera,
                                'sdd215d_cod_asign' => $asignatura,
                                'sdd215d_lapso_vigencia' => $lapso,
                                'sdd215d_version' => $version,
                                'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
                            ], [
                                // 'sdd215d_version' => 1,
                            
                                
                                'sdd215ds_nombre_tema' => $tema['nombre'],
                                'sdd215ds_contenido_tema' => $tema['contenido'],
                                'sdd215ds_profesor_creador' => Auth::id()
                            ]);
                        }

                        // si los temas cargados por el usuario son mayores a los temas q ya tiene la asginatura hay que eliminar el sobrante
                        if(count($temasexistentes)> 0 && ( count($temasexistentes) > count($temario))){
                            if(count($temasexistentes) > count($temario)){
                                for($i = count($temario) ; $i < count($temasexistentes) ; $i++){
                                    sdd215d::where('id', $temasexistentes[$i]->id)->delete();
                                }
                            }
                        }
                    }
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
                            'sdd210d_lapso_vigencia' =>  $asignado->sdd200d_lapso_vigencia,
                            'sdd210ds_version' => $version
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
                            'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                            'sdd210ds_estado' => 'rs'
                        ]
                        );
                        // se guardan los temas
                    if(isset($temario)){
                        foreach($temario as $tema){
                            error_log(json_encode($tema));
                            error_log($tema['nombre']);
                            sdd215d::updateOrCreate([
                                'sdd215d_cod_carr' => $carrera,
                                'sdd215d_cod_asign' => $asignatura,
                                'sdd215d_lapso_vigencia' => $lapso,
                                'sdd215d_version' => $version,
                                'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
                            ], [
                                // 'sdd215d_version' => 1,
                            
                                
                                'sdd215ds_nombre_tema' => $tema['nombre'],
                                'sdd215ds_contenido_tema' => $tema['contenido'],
                                'sdd215ds_profesor_creador' => Auth::id()
                            ]);
                        }

                        // si los temas cargados por el usuario son mayores a los temas q ya tiene la asginatura hay que eliminar el sobrante
                        if(count($temasexistentes)> 0 && ( count($temasexistentes) > count($temario))){
                            if(count($temasexistentes) > count($temario)){
                                for($i = count($temario) ; $i < count($temasexistentes) ; $i++){
                                    sdd215d::where('id', $temasexistentes[$i]->id)->delete();
                                }
                            }
                        }
                    }
                    return redirect()->route('plan.mostrarasignados');
                }

            }
        }elseif(Auth::user()->hasRole('administrador')){
            // si no esta asignado pero es administrador se crea igual


            // se guardan los temas
            if(isset($temario)){
                foreach($temario as $tema){
                    error_log(json_encode($tema));
                    error_log($tema['nombre']);
                    sdd215d::updateOrCreate([
                        'sdd215d_cod_carr' => $carrera,
                        'sdd215d_cod_asign' => $asignatura,
                        'sdd215d_lapso_vigencia' => $lapso,
                        'sdd215d_version' => $version,
                        'sdd215ds_orden_tema' => (int)$tema['orden'] + 1
                    ], [
                        // 'sdd215d_version' => 1,
                    
                        
                        'sdd215ds_nombre_tema' => $tema['nombre'],
                        'sdd215ds_contenido_tema' => $tema['contenido'],
                        'sdd215ds_profesor_creador' => Auth::id()
                    ]);
                }

                // si los temas cargados por el usuario son mayores a los temas q ya tiene la asginatura hay que eliminar el sobrante
                if(count($temasexistentes)> 0 && ( count($temasexistentes) > count($temario))){
                    if(count($temasexistentes) > count($temario)){
                        for($i = count($temario) ; $i < count($temasexistentes) ; $i++){
                            sdd215d::where('id', $temasexistentes[$i]->id)->delete();
                        }
                    }
                }
            }
            // se revisa si tiene estado
            $estado = App\Models\sdd200d::where('sdd200d_cod_carr', '=', $carrera)->where('sdd200d_cod_asign', '=', $asignatura)->where('sdd200d_lapso_vigencia', '=',$lapso)->first();
            // si tiene estado rj o c o ff esta en su estado de aprobacion final, por lo que se actualiza
            if( isset($estado->sdd200d_estado) && ($estado->sdd200d_estado == 'rj' || $estado->sdd200d_estado == 'c ' || $estado->sdd200d_estado == 'ff')){
                // $estado->sdd200d_estado ='ff';
                // $estado->save();

                // se elimina el estado ya que esta completo, ya no tiene a nadie asignado
                $estado->delete();

                // se actualizan los estados de los planes viejos
                sdd210d::where('sdd210ds_estado','=','a')->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', '=', $asignatura)->where('sdd210d_lapso_vigencia', '=',$lapso)->update(['sdd210ds_estado'=>'v']);

                //guardar datos
                sdd210d::updateOrCreate(
                    [
                        'sdd210d_cod_carr' => $estado->sdd200d_cod_carr,
                        'sdd210d_cod_asign' =>  $estado->sdd200d_cod_asign,
                        'sdd210d_lapso_vigencia' =>  $estado->sdd200d_lapso_vigencia,
                        'sdd210ds_version' => $version,
                        
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
                        'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                        'sdd210ds_estado' => 'a'
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
                        'sdd200d_version' => $version
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
                    'sdd210d_lapso_vigencia' =>  $existeasignatura->sdd090d_lapso_vigencia,
                    'sdd210ds_version' => $version
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
                    'sdd210ds_r_descripcion_red_tematica' => Request::input('descripcion_red_tematica'),
                    'sdd210ds_estado' => 'c'
                ]
                );
            }

            
        }

        
    }else{
        //error, asignatura no existe
    }
    

    if(Auth::user()->hasRole('administrador')){
        return redirect()->route('general.listarasignaturaslapsocarrerav2', ["carrera"=>$carrera, "lapso"=>$lapso, "version"=>$version]);
    }
    return redirect()->route('plan.mostrarasignados');
})->middleware(['auth'])->name('general.plancrearv2');


// crear relaciones entre asignaturas

Route::get('/{lapso}/{carrera}/{version}/relacion/crear', function(Request $reques,$lapso,$carrera, $version){
    // se listan las asignaturas para relacionar
    $relacion = DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where('sdd095_version', '=', (int)$version)->get();
    
    $mantenerpasado = false;
    error_log('entro1');
    if(count($relacion) == 0 && (int)$version > 1){
        // si no hay relacion con la version actual se revisa que la version anterior tenga y se pide si desea mantener los mismos
        error_log('entro');
        $nrel = (int)$version - 1;
        // $relacion = DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where(DB::raw('sdd095s.sdd095_version'), DB::raw($nrel))->get();
        $relacion = DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where('sdd095_version', '=', (int)$version-1)->get();

        error_log(json_encode($relacion));
        
        error_log(DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where('sdd095_version', 1)->toSql());
        if(count($relacion) > 0){
            // si se obtuvo relacion se agrega un parametro para saber si desea mantener los mismos que la version pasada
            error_log('entro2');
            $mantenerpasado = true;
        }
    }

    $asignaturas = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->get();
    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();
    
    // error_log(DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->toSql());
    // error_log(json_encode($relacion));
    // error_log($lapso);
    // error_log($carrera);
    return view('asignaturas.relacionarasignaturasv2',compact('asignaturas', 'carrera', 'lapso', 'relacion', 'mantenerpasado'));
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionarasignaturasv2');

//Relacion de asignaturas post
Route::post('/{lapso}/{carrera}/{version}/relacion/crearr', function(\Illuminate\Http\Request $reques, $lapso, $carrera,$version){
    // aqui se reciben los datos de las asignaturas relacioandas desde el front y se envia una respuesta

    // error_log('alo');
    error_log(Request::input('alo'));
    // error_log(json_encode($reques::all()));
    // error_log(json_encode($reques->all()));
    error_log(json_encode(Request::all()));
    error_log(json_encode(Request::input('data')));

    $datarelacion = json_decode(Request::input('data'));

    error_log(json_encode($datarelacion[0]));
    error_log(json_encode($datarelacion[0]->asignatura));
    error_log(json_encode($datarelacion[0]->relacion));
    error_log(count($datarelacion[0]->relacion));


    //despues se crean los nuevos
    // sdd095d::updateOrCreate(
    //     [
    //         'sdd095_lapso_vigencia'
    //         'sdd095_cod_carr', 
    //         'sdd095_cod_asign'
    //     ]
    // )

    try{
        //primero se eliminan los viejos valores de temas relacionados
        DB::table('sdd095ds')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where('sdd095_version', '=', $version)->delete();
        
        //se asignan los nuevos temas
        for($i = 0 ; $i < count($datarelacion); $i++){
            if(count($datarelacion[$i]->relacion) <= 0){
                
                continue;
            }elseif(count($datarelacion[$i]->relacion) == 1){


                DB::table('sdd095ds')->insert([
                    'sdd095_lapso_vigencia' => $lapso,
                    'sdd095_cod_carr' => $carrera, 
                    'sdd095_version' => (int)$version, 
                    'sdd095_cod_asign' => $datarelacion[$i]->asignatura,
                    'sdd095_nom_asignatura' => $datarelacion[$i]->nombre,
                    'sdd095_asignatura_relacion_cod' => $datarelacion[$i]->relacion[0]->id,
                    'sdd095_asignatura_relacion_nombre' => $datarelacion[$i]->relacion[0]->nombre
                ]);
            }else{
                for($j=0; $j < count($datarelacion[$i]->relacion) ; $j++){
                    DB::table('sdd095ds')->insert([
                        'sdd095_lapso_vigencia' => $lapso,
                        'sdd095_cod_carr' => $carrera, 
                        'sdd095_version' => (int)$version, 
                        'sdd095_cod_asign' => $datarelacion[$i]->asignatura,
                        'sdd095_nom_asignatura' => $datarelacion[$i]->nombre,
                        'sdd095_asignatura_relacion_cod' => $datarelacion[$i]->relacion[$j]->id,
                        'sdd095_asignatura_relacion_nombre' => $datarelacion[$i]->relacion[$j]->nombre
                    ]);
                }
            }

            error_log(json_encode($datarelacion[$i]->relacion));
        }
    }catch (Exception $e){
        return response()->json(array('msg'=> 'Error al insertar'), 400);
    }

    

    //aqui

    return response()->json(array('msg'=> 'insertado exitosamente'), 200);
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionarasignaturassv2');


Route::get('/{lapso}/{carrera}/{version}/relacionartemas', function(Request $request, $lapso, $carrera,$version){
    // sdd215d::select('*');

    $temasrelacionados = DB::table('sdd216ds')->select('*')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->where('sdd216d_version', '=', $version)->get();

    // las asignaturas relacionadas
    // DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->get();
    $asignaturasrelacionadas =DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where('sdd095_version', '=', $version)->get();

    $noasignaturas = false;
    if(count($asignaturasrelacionadas) == 0){
        $noasignaturas = true;
        error_log('pp');
    }

    $mantenerpasado = false;
    error_log('entro1');
    if(count($temasrelacionados) == 0 && (int)$version > 1){
        // si no hay temasrelacionados con la version actual se revisa que la version anterior tenga y se pide si desea mantener los mismos
        error_log('entro');
        $nrel = (int)$version - 1;
        $temasrelacionados = DB::table('sdd216ds')->select('*')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->where('sdd216d_version', '=',(int)$version -1)->get();
        $asignaturasrelacionadas =DB::table('sdd095ds')->select('*')->where('sdd095_lapso_vigencia', '=', $lapso)->where('sdd095_cod_carr', '=', $carrera)->where('sdd095_version', '=', (int)$version-1)->get();
        if(count($temasrelacionados) > 0){
            // si se obtuvo relacion se agrega un parametro para saber si desea mantener los mismos que la version pasada
            error_log('entro2');
            $mantenerpasado = true;
        }
    }

    //todos los temas de esta carrera en este lapso
    $temas = DB::table('sdd215ds')->select('*')->where('sdd215ds.sdd215d_lapso_vigencia', '=', $lapso)->where('sdd215ds.sdd215d_cod_carr', '=', $carrera)->where('sdd215d_version', '=', $version)->orderBy('sdd215ds.created_at')->get();

    // todas las asignaturas de esta carrera en este lapso
    $asignaturas = DB::table('sdd090ds')->select('*')->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)->orderBy('sdd090ds.sdd090d_nivel_asignatura')->get();

    

    // los datos de la carrera
    $carrera = App\Models\sdd080d::where('sdd080d_cod_carr', '=', $carrera)->get()->first();

    return view('asignaturas.relacionartemaasignaturasv2')->with(compact('temas', 'asignaturas', 'carrera', 'lapso', 'asignaturasrelacionadas', 'temasrelacionados', 'mantenerpasado','noasignaturas'));
    
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionartemasv2');

Route::post('/{lapso}/{carrera}/{version}/relacionartemas', function(Request $request, $lapso, $carrera,$version){

    $datarelacion = json_decode(Request::input('data'));
    $resetear = json_decode(Request::input('resetear'));
    error_log(json_encode($datarelacion));
    if(isset($resetear) ){
        if($resetear == 1){
            DB::table('sdd216ds')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->where('sdd216d_version', '=',$version)->delete();
            return response()->json(array('msg'=> 'eliminado exitosamente'), 200);
        }
        
    }else{
        error_log(json_encode($datarelacion));
        try{
            //primero se eliminan los viejos valores de temas relacionados
            DB::table('sdd216ds')->where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->where('sdd216d_version', '=',$version)->delete();
            for($i = 0 ; $i < count($datarelacion); $i++){
                error_log('i'.$i.'   '.count($datarelacion) );
                for($j = 0 ; $j < count($datarelacion[$i]->relaciones); $j++){
                    error_log('j'.$j. '   '. count($datarelacion[$i]->relaciones));
                    DB::table('sdd216ds')->insert([
                        "sdd216d_lapso_vigencia" => $lapso, 
                        "sdd216d_cod_carr" => $carrera, 
                        "sdd216d_cod_asign" => $datarelacion[$i]->asignaturaPadre, 
                        "sdd216d_version" => (int)$version, 
                        "sdd216d_cod_asign_relacion" => $datarelacion[$i]->relaciones[$j]->asignatura, 
                        "sdd216d_nom_asignatura" => $datarelacion[$i]->asignaturaPadreNombre, 
                        "sdd216d_nom_asignatura_relacion" => $datarelacion[$i]->relaciones[$j]->asignaturaNombre,
                        "sdd216d_id_tema_asignatura_principal" => $datarelacion[$i]->temaId, 
                        "sdd216d_nom_tema_asignatura_principal" => $datarelacion[$i]->temaPadreNombre, 
                        "sdd216d_id_tema_asignatura_relacion" => $datarelacion[$i]->relaciones[$j]->temaId, 
                        "sdd216d_nom_tema_asignatura_relacion" => $datarelacion[$i]->relaciones[$j]->temaNombre,
                        "sdd216d_version" => $version
                    ]);
                }
                
            }
            
            
            //se asignan los nuevos temas
        }catch (Exception $e){
            error_log(json_encode($e));
            return response()->json(array('msg'=> 'Error al insertar '.$e), 400);
            
        }

        error_log('here');
        return response()->json(array('msg'=> 'insertado exitosamente'), 200);
    }
    
})->middleware(['auth','role:administrador'])->name('asignaturas.relacionartemasv2');


Route::get('/busqueda', function(){
    $planes = DB::table('sdd100ds')->select('*')->join('sdd080ds', 'sdd080ds.sdd080d_cod_carr','=','sdd100ds.sdd100d_cod_carr')->orderBy('sdd100ds.sdd100d_cod_carr', 'asc')->orderBy('sdd100ds.sdd100d_lapso', 'asc')->get();
    return view('general.busqueda')->with('planes',$planes);
})->name('general.busqueda');

Route::post('/busqueda/obtener-asignaturas', function(Request $request){
    error_log('alo');
    error_log(json_encode(Request::post()));
    error_log(json_encode(Request::input('lapso')));
    $planes = DB::table('sdd100ds')->select('*')->join('sdd080ds', 'sdd080ds.sdd080d_cod_carr','=','sdd100ds.sdd100d_cod_carr')->orderBy('sdd100ds.sdd100d_cod_carr', 'asc')->orderBy('sdd100ds.sdd100d_lapso', 'asc')->get();

    $lapso = Request::input('lapso');
    $carrera = Request::input('carrera');
    
    $asignaturas = DB::table('sdd090ds')->select('sdd110d_semestre', 'sdd090d_cod_carr', 'sdd080d_nom_carr','sdd090d_nom_asign' ,'sdd200d_estado',  'sdd210ds_version','sdd210ds_estado','sdd210d_lapso_vigencia','sdd090d_cod_asign','sdd210d_lapso_vigencia')->leftjoin('sdd200ds', function($join){
        $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
    })->rightjoin('sdd210ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
    })
    ->rightjoin('sdd110ds', function($join) use ($carrera, $lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
            $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
        
    })
    ->rightjoin('sdd080ds', function($join) use ($carrera,$lapso){
        $join->on(function($query) use($carrera, $lapso) {
            $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd080ds.sdd080d_cod_carr');
            $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
            $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
        });
    })
    ->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)
    ->where(function ($query){
        $query->where('sdd210ds_estado', '=', 'a ')->orWhere('sdd210ds_estado', '=', 'v ');
    })
    ->orderBy('sdd110d_semestre')
    ->orderBy('sdd090d_cod_asign','desc')
    // ->orderByRaw('CASE WHEN "sdd110d_semestre" = '."0".' THEN '.'"asdf"'.' ELSE "sdd110d_semestre" END DESC, "sdd110d_semestre" ASC')
    // ->orderBy('sdd090ds.sdd090d_nivel_asignatura')->orderBy('sdd090ds.sdd090d_cod_asign')->orderBy('sdd210ds_version', 'ASC')
    ->get();

    error_log(
        DB::table('sdd090ds')->select('sdd110d_semestre', 'sdd090d_cod_carr', 'sdd080d_nom_carr','sdd090d_nom_asign' ,'sdd200d_estado',  'sdd210ds_version','sdd210ds_estado')->leftjoin('sdd200ds', function($join){
            $join->on('sdd090ds.id', '=', 'sdd200ds.sdd200d_plan_asignatura_id');
        })->rightjoin('sdd210ds', function($join) use ($carrera, $lapso){
            $join->on(function($query) use($carrera, $lapso) {
                $query->on('sdd210ds.sdd210d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
                $query->on('sdd210ds.sdd210d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
                $query->on('sdd210ds.sdd210d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
            });
        })
        ->rightjoin('sdd110ds', function($join) use ($carrera, $lapso){
            $join->on(function($query) use($carrera, $lapso) {
                $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd090ds.sdd090d_cod_carr');
                $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
                $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
            });
            
        })
        ->rightjoin('sdd080ds', function($join) use ($carrera,$lapso){
            $join->on(function($query) use($carrera, $lapso) {
                $query->on('sdd110ds.sdd110d_cod_carr', '=', 'sdd080ds.sdd080d_cod_carr');
                $query->on('sdd110ds.sdd110d_lapso_vigencia', '=', 'sdd090ds.sdd090d_lapso_vigencia');
                $query->on('sdd110ds.sdd110d_cod_asign', '=', 'sdd090ds.sdd090d_cod_asign');
            });
        })
        ->where('sdd090ds.sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090ds.sdd090d_cod_carr', '=', $carrera)
        ->where(function ($query){
            $query->where('sdd210ds_estado', '=', 'a ')->orWhere('sdd210ds_estado', '=', 'v ');
        })->toSql()
    );

    if(count($asignaturas) > 0){
        return response()->json(array('msg'=> 'Datos encontrados', 'data'=>$asignaturas), 200);
    }else{
        return response()->json(array('msg'=> 'No se encontro datos'), 400);
    }

    
})->name('general.busquedaasignaturas');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
