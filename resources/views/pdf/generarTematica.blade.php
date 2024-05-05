<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tematica</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
    <style>
        body{
            font-family: sans-serif;
        }
        .datos__identificacion{
            border: 1px solid black;

        }
        .column{
            display: inline;
            height: 100%;
            height: 30px;
        }
        .row1 .column1{
            width: 15%;
        }
        .row1 .column{
            width: 85%;
        }
        .row{
            border-bottom: 1px solid black;
            height: 30px;
        }
        .datos__identificacion .row .column{
            border-right: 1px solid black
        }
        .datos__identificacion .row .column:last-of-type{
            border-right: none;
        }
        .programa_estudio{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }
        .programa_estudio_element{
            border-right: 1px solid black;
            display: inline;
            width: 25%;
        }
        .programa_estudio_element:last-of-type{
            border-right: none;
        }
        *{
            box-sizing: border-box;
        }
        .column *{
            display: inline;
        }


        .tabla tr{
            border: 1px solid black;
        }
        .tabla td{
            border-right: solid 1px black;
            padding-left: 5px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .nopad td{
            padding-left: 0px;
        }
        .line{
            width: 100%;
            display: block;
            height: 1px;
            background: black;
        }
        .tabla{
            font-size: 14px;
            border-collapse: collapse;

        }
        *{
            font-size: 14px;
        }
        .tabla tr td:last-of-type{
            border-right: none;
        }

        header {
            position: fixed;
            top: -70px;
            left: 0px;
            right: 0px;
            height: 60px;

            /** Extra personal styles **/
            text-align: center;
            line-height: 35px;
        }
        header img{
            height: 70px;
            display: inline-block;
            max-width: 30%;
            position: left;
        }
        header div{
            text-align: center;
            width: 70%;
            font-weight: 900;
            display: inline-block;
        }
        header p{
            color: black;
            margin: 0;
            padding: 0;
            line-height: 1;
            font-size: 16px;
            font-style: italic;
            font-weight: 700ñ
        }

        h2 span{
            width: 1cm;
            display: inline-block;
        }
        h2{
            vertical-align: center;
            margin-top: 4rem;
            margin-bottom: .5rem;
        }
        
        h2,h3,h4{
            margin-bottom: 0 !important;
        }
        body > h2:first-of-type{
            margin-top: .5cm;
            margin-bottom: 0.5cm !important;
        }
        p{
            padding-left: 1cm;
        }
        h3{
            padding-left: 1cm;

        }
        p{
            margin-top: 0;
            margin-bottom: 0;
        }
        h4{
            padding-left: 2cm;
        }
        ul li{
            margin-left: 1cm
        }
        .curriculo{
            width: 30%;
            display: inline;
        }
        @page {
            margin: 100px 70px 100px 100px;
        }
    </style>
</head>
<body>

    <!-- Define header and footer blocks before your content -->
    <header>
        <img src="{{public_path('LOGO_UNEG.jpg')}}" alt="">
        <div>
            <p>Universidad Nacional Experimental de Guayana</p>
            <p>Vicerrectorado Académico</p>
            <p>Coordinación de Currículo</p>
        </div>
        <div class="curriculo">
            <img src="{{public_path('logo_curriculo.jpg')}}" alt="">
        </div>
    </header>

    

    <h2><span>I.</span><strong>DATOS DE IDENTIFICACION:</strong></h2>

    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none; table-layout: fixed;">
        <colgroup>
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
            <col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%"><col width="1%">
        </colgroup>
        <tr>
            <td colspan='15' style="text-align: center"><strong>Nombre del Proyecto de Carrera</strong></td>
            <td colspan='85' style="border-right: none"><strong>
                {{$carrera->sdd080d_nom_carr}}
            </strong></td>
        </tr>
        <tr>
            <td colspan='15' style="border-right:solid 1px black; text-align:center;"><strong>Programa de Estudio</strong></td>
            <td colspan='19' style="border-right: solid 1px black;">Tecnologo</td>
            <td colspan='3'></td>
            <td colspan='18' style="border-right: solid 1px black;">Licenciado</td>
            <td colspan='3'></td>
            <td colspan='18' style="border-right: solid 1px black;">Ingeniero</td>
            <td colspan='3'></td>
            <td colspan='18' style="border-right: solid 1px black">Diplomado</td>
            <td colspan='3' style="border-right: none;"></td>

        </tr>
        <tr>
            <td colspan="15" style="text-align: center">
                <strong>Unidad Didáctica de Aprendizaje</strong>
            </td>
            <td colspan="43">
                {{$asignatura->sdd090d_nom_asign}}
            </td>
            <td colspan="42">
                <strong>SEMESTRE:</strong> 
            </td>
        </tr>
        <tr>
            <td colspan="15" style="text-align: center">
                <strong>Régimen de Estudio</strong>
            </td>
            <td colspan="19" style="text-align: center">
                <strong>Duración del Programa</strong>
            </td>
            <td colspan="5" style="text-align: center">
                <strong>UC</strong>
            </td>
            <td colspan="6" style="text-align: center">
                <strong>HS</strong>
            </td>
            <td colspan="8" style="text-align: center">
                <strong>HSEM</strong>
            </td>
            <td colspan="47" style="text-align: center">
                <strong>UNIDADES DIDACT DE APREN INTEGRADAS</strong>
            </td>
        </tr>
        <tr>
            <td colspan="15" style="text-align: center; height: 2rem;">
                Semestral
            </td>
            <td colspan="19" style="text-align: center; height: 2rem;">
            </td>
            <td colspan="5" style="text-align: center; height: 2rem;">
                
            </td>
            <td colspan="6" style="text-align: center; height: 2rem;">
                
            </td>
            <td colspan="8" style="text-align: center; height: 2rem;">
                
            </td>
            <td colspan="47" style="text-align: center; height: 2rem;">
                
            </td>
        </tr>
        <tr>
            <td colspan="35" rowspan="2" style="text-align: center; vertical-align: center;">
                <strong>Eje de formación</strong>
            </td>
            <td colspan="18" style="text-align: center">
                Integral-Creativo
            </td>
            <td colspan="3"></td>
            <td colspan="18" style="text-align: center">
                Ciencia y Tecnología
            </td>
            <td colspan="3">

            </td>
            <td colspan="20" style="text-align: center">
                Profesional - Tecnológico
            </td>
            <td colspan="3">
                
            </td>
        </tr>
        <tr>
            <td colspan="18" style="text-align: center">
                Socio-Ambiental
            </td>
            <td colspan="3"></td>
            <td colspan="18" style="text-align: center">
                Innovación - Producción
            </td>
            <td colspan="3">

            </td>
            <td colspan="20" style="text-align: center">
                Práctica Profesional
            </td>
            <td colspan="3">
                
            </td>
        </tr>
        <tr>
            <td colspan="35" style="text-align: left;">
                <strong>Carácter de la Unidad Curricular</strong>
            </td>
            <td colspan="29" style="text-align: center">
                Obligatoria
            </td>
            <td colspan="3"></td>
            <td colspan="30">
                Electiva
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="35">
                <strong>
                    Requisitos para Cursar la
                    Unidad Didáctica de
                    Aprendizaje (Prelaciones):
                </strong>
            </td>
            <td colspan="65">

            </td>
        </tr>
        <tr>
            <td colspan="65">Elaborado por: </td>
            <td colspan="35"><strong>Fecha: </strong></td>
        </tr>
        <tr>
            <td colspan="100">
                <strong>VºBº Coordinador (a) del Programa o Proyecto</strong>
            </td>
        </tr>
        <tr>
            <td colspan="12">Nombre:</td>
            <td colspan="38"></td>
            <td colspan="50">Firma:</td>
        </tr>
        <tr>
            <td colspan="100">
                <strong>VºBº Coordinador (a) de Currículo:</strong>
            </td>
        </tr>
        <tr>
            <td colspan="12">Nombre:</td>
            <td colspan="38"></td>
            <td colspan="50">Firma:</td>
        </tr>
    </table>

    <div>
        <h2><span>II.</span><strong>PROPÓSITO: (AFECTIVO, INTELECTUAL Y SOCIAL):</strong></h2>
        <p>
            @if(isset($plan->sdd210ds_as_proposito) && $plan->sdd210ds_as_proposito != '')
            {{$plan->sdd210ds_as_proposito}}
            @endif
        </p>
        <h2><span>III.</span><strong>CAPACIDADES Y HABILIDADES A DESARROLLAR:</strong></h2>
        <h4>Capacidades:</h4>
        <ul>
            @if(isset($capacidades) && $capacidades)
                @foreach($capacidades as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h4>Habilidades:</h4>
        <ul>
            @if(isset($habilidades) && $habilidades)
                @foreach($habilidades as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h2><span>IV.</span><strong>CAPACIDADES PROFESIONALES:</strong></h2>
        <ul>
            @if(isset($capacidadestematica) && $capacidadestematica)
                @foreach($capacidadestematica as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h2><span>V.</span><strong>VALORES Y ACTITUDES:</strong></h2>
        <ul>
            @if(isset($valoresactitudes) && $valoresactitudes)
                @foreach($valoresactitudes as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h2><span>VI.</span><strong>RED TEMATICA:</strong></h2>
        <ul>
            @if(isset($red_tematica) && $red_tematica)
                @foreach($red_tematica as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h2><span>VII.</span><strong>DESCRIPCIÓN DETALLADA DE LA RED TEMÁTICA:</strong></h2>
        <p>
            {{$plan->sdd210ds_r_descripcion_red_tematica}}
        </p>
        <h2><span>VIII.</span><strong>ESTRATEGIAS DIDÁCTICAS:</strong></h2>
        <h3>ESTRATEGIAS DOCENTES</h3>
        <ul>
            @if(isset($estrategias_docentes) && $estrategias_docentes)
                @foreach($estrategias_docentes as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h3>ESTRATEGIAS DE APRENDIZAJES</h3>
        <ul>
            @if(isset($estrategias_aprendizaje) && $estrategias_aprendizaje)
                @foreach($estrategias_aprendizaje as $capa)
                    @if($capa->type == 'paragraph')
                        <p>{{$capa->data->text}}</p>
                    @elseif($capa->type == 'list')
                        @foreach($capa->data->items as $item)
                        <li>{{$item->content}}</li>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </ul>
        <h2><span>IX.</span><strong>PLAN DE EVALUACIÓN:</strong></h2>
        <h3>ESTRATEGIAS DE EVALUACION:</h3>
        <ul>
            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laudantium nihil, molestiae eos nobis excepturi consequuntur fugit magni perspiciatis! Libero laudantium sequi, sit repellendus quaerat quisquam dolores incidunt quia necessitatibus. Velit!</li>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque laboriosam deserunt repudiandae dolores maxime cum quis officiis nihil placeat officia. Animi consequatur similique facilis tempora ducimus neque voluptatem praesentium at.
        </ul>

        <h2>TEMAS DE INVESTIGACIÓN, ANÁLISIS Y EVALUACIÓN.</h2>
        <p><strong>1.- - Introducción al estudio de la Administración Financiera y las Finanzas Corporativas.</strong></p>
        <p>Explicar las funciones financieras básica de la organización y su ubicación dentro de la
            estructura organizativa, el objetivo de la administración financiera, los aspectos importantes y
            necesarios para el análisis del flujo de efectivo, y el rol del gerente financiero y sus funciones
            fundamentales. Explicar el objetivo de la finanzas corporativas y evaluar aspectos necesarios
            para el análisis de los Estados Financieros.
        </p>

        <h2><span>X</span><strong>REFERENCIAS BIBLIOGRÁFICAS:</strong></h2>
        <p class="biblio">BALDWIN JORGE y BALDWIN DARLOS, (1990) FINANZA DE LA EMPRESA. Editorial Norma,
            Colombia.</p>
    </div>

</body>
</html>