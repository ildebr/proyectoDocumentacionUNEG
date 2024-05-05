<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
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
            padding-top: 3px;
            padding-bottom: 3px;
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

        .tabla tr td:last-of-type{
            border-right: none;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>
<body>

    <!-- Define header and footer blocks before your content -->
    <header>
        Our Code World
    </header>

    <h2>I.DATOS DE IDENTIFICACION</h2>

    <div class="datos__identificacion container">
        <div class="row row1" style="height: 40px">
            <div class="column column1">
                <strong>Proyecto de Carrera:</strong>
            </div>
            <div class="column column2">
                {{$proyecto_de_carrera}}
            </div>
        </div>
        <div class="row row2" style="height: 40px">
            <div class="column column1" s>
                <strong>Proyecto de Estudio:</strong>
            </div>
            <div class="column column2">
                <div class="programa_estudio">
                    <div class="programa_estudio_element">
                        <span>Tecnologo</span>
                        <div></div>
                    </div>
                    <div class="programa_estudio_element">
                        <span>Licenciado</span>
                        <div></div>
                    </div>
                    <div class="programa_estudio_element">
                        <span>Ingeniero</span>
                        <div></div>
                    </div>
                    <div class="programa_estudio_element">
                        <span>Diplomado</span>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- 
    <table class="tabla" style="border:1px solid black;">
        <tr style="display: inline-block">
            <th width='15%' style="border-right:solid 1px black; text-align:left; border-bottom:1px solid black; display: inline-block;"><strong>Proyecto de Carrera</strong></th>
            <th width='85%' style="border-bottom:solid 1px black; display: inline-block;">{{$proyecto_de_carrera}}</th>
        </tr>
        <tr>
            <td width='15%'><strong>Proyecto de Carrera</strong></td>
            <td width='85%'>{{$proyecto_de_carrera}}</td>
        </tr>
        <div class="line"></div>
        <tr>
            <td width='15%' style="border-right:solid 1px black; text-align:left;">Programa de Estudio</td>
            <td width='21.25%' style="border-right: solid 1px black;">Tecnologo</td>
            <td width='21.25%' style="border-right: solid 1px black;">Licenciado</td>
            <td width='21.25%' style="border-right: solid 1px black;">Ingeniero</td>
            <td width='21.25%' >Diplomado</td>

        </tr>
    </table> --}}

    <table class="tabla" style="border:1px solid black; width: 100%; border-bottom: none">
        <tr>
            <td width='15%'><strong>Proyecto de Carrera</strong></td>
            <td width='85%' style="border-right: none"><strong>{{$proyecto_de_carrera}}</strong></td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; border-bottom:none">
        <tr>
            <td width='15%' style="border-right:solid 1px black; text-align:left;"><strong>Programa de Estudio</strong></td>
            <td width='18.25%' style="border-right: solid 1px black;">Tecnologo</td>
            <td width='3%'></td>
            <td width='18.25%' style="border-right: solid 1px black;">Licenciado</td>
            <td width='3%'></td>
            <td width='18.25%' style="border-right: solid 1px black;">Ingeniero</td>
            <td width='3%'></td>
            <td width='18.25%' style="border-right: solid 1px black">Diplomado</td>
            <td width='3%' style="border-right: none;"></td>

        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; border-bottom: none;">
        <tr>
            <td width='15%'><strong>Unidad Curricular</strong></td>
            <td width='85%' style="border-right: none">{{$unidad_curricular}}</td>
        </tr>
    </table>
    <table class="tabla nopad" style="border:1px solid black; width: 100%; border-bottom:none">
        <tr style="border-bottom: solid 1px black">
            <td width='15%' style="text-align: center;"><strong>Semestre</strong></td>
            <td width='15%' style="text-align: center;"><strong>Codigo</strong></td>
            <td width='15%' style="text-align: center;"><strong>Unidad de Credito</strong></td>
            <td width='27.5%' style="text-align: center;"><strong>HAD</strong></td>
            <td width='27.5%' style="text-align: center;"><strong>Horas Semestre</strong></td>
        </tr>
        
    </table>
    <table class="tabla nopad" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr style="border-top: 1px solid black; margin: 0; padding: 0">
            <td width='15%' style="text-align: center; height: 28px; padding-top: 2px">I</td>
            <td width='15%' style="text-align: center; height: 28px; padding-top: 2px">1549101</td>
            <td width='15%' style="text-align: center; height: 28px; padding-top: 2px">3</td>
            <td width='27.5%' style="text-align: center; height: 28px; padding-top: 2px">4</td>
            <td width='27.5%' style="text-align: center; height: 28px; padding-top: 2px">64</td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr style="border-bottom: 1px solid black">
            <td rowspan="2" width='33%'>
                <strong>Componente de formacion</strong>
            </td>
            <td>General</td>
            <td width='3%'> </td>
            <td>Profesional basica</td>
            <td  width='3%'>

            </td>
            <td>Profesional especializada</td>
            <td width='3%' style="border-right: solid 1px black; border-bottom: solid 1px black;"> </td>
        </tr>
        <tr style="border-top: solid 1px black;">
            <td style="padding-right: 8px">Practica profesional</td>
            <td width='3%'> </td>
            <td>Pasantia</td>
            <td width='3%'> </td>
            <td style="border-right: solid 1px black; border-bottom: 1px solid black;"></td>
            <td width='3%' style="border-right: solid 1px black; border-bottom: solid 1px black;"> </td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr>
            <td width='33%'>
                <strong>Caracter de la Unidad Curricular</strong>
            </td>
            <td width='29.5%'>Obligatoria</td>
            <td width='4%'></td>
            <td width='29.5%'>Electiva</td>
            <td width='4%'></td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr>
            <td width='33%'>
                <strong>Requisitos para Cursar la Unidad Curricular (Prelaciones):</strong>
            </td>
            <td width='67%'>NINGUNO</td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none; table-layout:fixed;">
        <tr>
            <td width='67%'><strong>ELABORADO POR:</strong> CARMEN VAS</td>
            <td width='33%' colspan="2">
                <strong>Fecha: 27-09-2011</strong>
            </td>
        </tr>
        
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr>
            <td width='10%'>Coordinador (a) del Proyecto de Carrera:</td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr>
            <td width='10%'>Nombre:</td>
            <td width='40%'>Licd. Lisbeth Perez</td>
            <td width='50%'>Firma:</td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr>
            <td width='10%'>Coordinador (a) del Proyecto de Carrera:</td>
        </tr>
    </table>
    <table class="tabla" style="border:1px solid black; width: 100%; margin:0; padding: 0; border-bottom:none">
        <tr>
            <td width='10%'>Nombre:</td>
            <td width='40%'>MSc. Maria Mentor</td>
            <td width='50%'>Firma:</td>
        </tr>
    </table>

    <div>
        <h3>II. PROPOSITO</h3>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque magnam impedit quos laudantium possimus, corrupti maiores, nisi deserunt blanditiis dignissimos aut animi vel, sequi et explicabo quis at harum. Atque!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est repellat eveniet nam quo. Quam libero tenetur quas vel iusto voluptates, eaque facilis culpa quod aperiam ullam, doloremque laborum distinctio. Velit?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus iusto reprehenderit ducimus eius, est veniam, atque, molestias sint obcaecati dolorem natus exercitationem maiores quia praesentium ad laudantium illum ipsa commodi.
        </p>
    </div>
    <div>
        <h3>II. PROPOSITO</h3>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque magnam impedit quos laudantium possimus, corrupti maiores, nisi deserunt blanditiis dignissimos aut animi vel, sequi et explicabo quis at harum. Atque!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est repellat eveniet nam quo. Quam libero tenetur quas vel iusto voluptates, eaque facilis culpa quod aperiam ullam, doloremque laborum distinctio. Velit?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus iusto reprehenderit ducimus eius, est veniam, atque, molestias sint obcaecati dolorem natus exercitationem maiores quia praesentium ad laudantium illum ipsa commodi.
        </p>
    </div>
    <div>
        <h3>II. PROPOSITO</h3>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque magnam impedit quos laudantium possimus, corrupti maiores, nisi deserunt blanditiis dignissimos aut animi vel, sequi et explicabo quis at harum. Atque!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est repellat eveniet nam quo. Quam libero tenetur quas vel iusto voluptates, eaque facilis culpa quod aperiam ullam, doloremque laborum distinctio. Velit?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus iusto reprehenderit ducimus eius, est veniam, atque, molestias sint obcaecati dolorem natus exercitationem maiores quia praesentium ad laudantium illum ipsa commodi.
        </p>
    </div>
    <div>
        <h3>II. PROPOSITO</h3>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque magnam impedit quos laudantium possimus, corrupti maiores, nisi deserunt blanditiis dignissimos aut animi vel, sequi et explicabo quis at harum. Atque!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est repellat eveniet nam quo. Quam libero tenetur quas vel iusto voluptates, eaque facilis culpa quod aperiam ullam, doloremque laborum distinctio. Velit?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus iusto reprehenderit ducimus eius, est veniam, atque, molestias sint obcaecati dolorem natus exercitationem maiores quia praesentium ad laudantium illum ipsa commodi.
        </p>
    </div>
    <div>
        <h3>II. PROPOSITO</h3>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque magnam impedit quos laudantium possimus, corrupti maiores, nisi deserunt blanditiis dignissimos aut animi vel, sequi et explicabo quis at harum. Atque!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est repellat eveniet nam quo. Quam libero tenetur quas vel iusto voluptates, eaque facilis culpa quod aperiam ullam, doloremque laborum distinctio. Velit?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus iusto reprehenderit ducimus eius, est veniam, atque, molestias sint obcaecati dolorem natus exercitationem maiores quia praesentium ad laudantium illum ipsa commodi.
        </p>
    </div>
    

    {{-- <div style="border: 1px solid black">
        <div>
            <div style="border:1px solid black; border-bottom:none; ">
                <div style="width:18%; display:inline; float:left;">
                    <strong>Proyecto de Carrera</strong>
                </div>
                <div style="display: inline; border-left: 1px solid black; width:82%; float:right;">
                    <strong>{{$proyecto_de_carrera}}</strong>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div>
            <div style="border:1px solid black; border-bottom: 1px solid black;">
                <div style="width:18%;height:40px; display:inline; float:left; height: 100%;">
                    <strong>Programa de Estudio</strong>
                </div>
                <div style="display: inline; height:40px; border-left: 1px solid black; width:82%; float:right;">
                    <strong>{{$proyecto_de_carrera}}</strong>
                </div>
            </div>
        </div>
    </div> --}}

</body>
</html>