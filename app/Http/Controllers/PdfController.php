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

        // obtenemos los datos del archivo pdf para generarlo
        $plan = sdd210d::where('sdd210d_lapso_vigencia', '=', $lapso)->where('sdd210d_cod_carr', '=', $carrera)->where('sdd210d_cod_asign', '=', $asignatura)->where('sdd210ds_version', '=', $version)->first();
        error_log($plan->toArray);
        $asignatura = sdd090d::where('sdd090d_lapso_vigencia', '=', $lapso)->where('sdd090d_cod_carr', '=', $carrera)->where('sdd090d_cod_asign', $asignatura)->first();
        $carrera = sdd080d::where('sdd080d_cod_carr', '=', $carrera)->first();
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
            



            $pdf = Pdf::loadView('pdf.generarTematica', compact('plan', 'asignatura', 'carrera', 'capacidades', 'estrategias_aprendizaje', 'habilidades', 'capacidadestematica', 'valoresactitudes', 'red_tematica', 'estrategias_docentes', 'capacidades'));
            return $pdf->download('tematica.pdf');
        }else{
            abort(403, 'No existe esta pagina');
        }



        return redirect('dashboard');
    }
}
