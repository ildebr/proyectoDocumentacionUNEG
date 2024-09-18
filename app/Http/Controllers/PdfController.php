<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\sdd210d;
use App\Models\sdd090d;
use App\Models\sdd080d;
use App\Models\sdd200d;
use App\Models\sdd110d;
use App\Models\sdd215d;
use App\Models\sdd216d;

class PdfController extends Controller
{
    //

    public function generatePdf(){
        $users = User::get();
        $data = [
            'title'=> 'Fund of Web IT',
            'date' => date('m/d/Y'),
            'users' => $users,
            'proyecto_de_carrera' => 'EDUCACION MENCIÓN: EDUCACÓN FÍSICA DEPORTE Y RECREACIÓN',
            'unidad_curricular' => 'Comprension y Expresion Linguistica'
        ];
        
        $pdf = Pdf::loadView('pdf.generarSinoptico', $data);
        return $pdf->download('sinoptico.pdf');
    }

    public function generateTematicaPdf(Request $request, $lapso, $carrera, $asignatura, $version){
        error_log($lapso);
        error_log($carrera);
        error_log($asignatura);
        error_log($version);
        $semestre = sdd110d::where('sdd110d_lapso_vigencia', '=', $lapso)->where('sdd110d_cod_carr', '=', $carrera)->where('sdd110d_cod_asign', $asignatura)->first();
        $temas = sdd215d::where('sdd215d_lapso_vigencia', '=', $lapso)->where('sdd215d_cod_carr', '=', $carrera)->where('sdd215d_cod_asign', $asignatura)->get();
        $relaciontematica = sdd216d::where('sdd216d_lapso_vigencia', '=', $lapso)->where('sdd216d_cod_carr', '=', $carrera)->where('sdd216d_cod_asign', $asignatura)->orderBy('sdd216d_cod_asign')->orderBy('sdd216d_id_tema_asignatura_principal')->orderBy('sdd216d_cod_asign_relacion')->get();
        // error_log(json_encode($relaciontematica));
        // obtenemos los datos del archivo pdf para generarlo
        $plan = sdd210d::where('sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', '=', $asignatura)->where('sdd210ds_version', '=', $version)->first();
        error_log($plan->toArray);
        $asignatura = sdd090d::where('sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090d_cod_carr', '=', $carrera)->where('sdd090d_cod_asign', $asignatura)->first();
        $carrera = sdd080d::where('sdd080d_cod_carr', '=', $carrera)->first();
        error_log($carrera);
        error_log((int)$carrera->sdd080d_ordern_tecnicos);
        

        if($plan){

            //decode what is saved as json
            $capacidades = json_decode($plan->sdd210ds_r_capacidades);
            if($capacidades){
                $capacidades = $capacidades->blocks;
            }
            $habilidades = json_decode($plan->sdd210ds_r_habilidades);
            if($habilidades){
                $habilidades = $habilidades->blocks;
            }
            $capacidadestematica = json_decode($plan->sdd210ds_r_capacidades_profesionales);
            if($capacidadestematica){
                $capacidadestematica = $capacidadestematica->blocks;
            }
            $valoresactitudes = json_decode($plan->sdd210ds_a_valores_actitudes);
            if($valoresactitudes){
                $valoresactitudes = $valoresactitudes->blocks;
            }
            $red_tematica = json_decode($plan->sdd210ds_r_red_tematica);
            if($red_tematica){
                $red_tematica = $red_tematica->blocks;
            }
            $estrategias_docentes = json_decode($plan->sdd210ds_r_capacidades);
            if($estrategias_docentes){
                $estrategias_docentes = $estrategias_docentes->blocks;
            }
            $estrategias_aprendizaje = json_decode($plan->sdd210ds_as_estrategias_aprendizajes);
            if($estrategias_aprendizaje){
                $estrategias_aprendizaje = $estrategias_aprendizaje->blocks;
            }
            $bibliografia = json_decode($plan->sdd210ds_as_bibliografia);
            if($bibliografia){
                $bibliografia = $bibliografia->blocks;
            }
            



            $pdf = Pdf::loadView('pdf.generarTematica', compact('plan', 'asignatura', 'carrera', 'capacidades', 'estrategias_aprendizaje', 'habilidades', 'capacidadestematica', 'valoresactitudes', 'red_tematica', 'estrategias_docentes', 'capacidades', 'semestre', 'temas', 'bibliografia', 'relaciontematica'));
            return $pdf->download('tematica.pdf');
        }else{
            abort(403, 'No existe esta pagina');
        }



        return redirect('dashboard');
    }
}
