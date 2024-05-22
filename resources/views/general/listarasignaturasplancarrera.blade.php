<x-app-layout>
    <style>
        .hide{
            display: none;
        }
    </style>
    <div class="py-12" id="listarplanes">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Lista de asignaturas
                    </h2>

                    

                    <p>Estas viendo las asignaturas de la carrera: <strong>{{$carrera['sdd080d_nom_carr']}}</strong>, codigo <strong class="codigo_carrera">{{$carrera['sdd080d_cod_carr']}}</strong> con el lapso de vigencia <strong class="lapso_vigencia">{{$lapso}}</strong></p>

                    <p>Para asignar asignaturas a un profesor/coordinador selecciona las asignaturas primero y despues presiona el boton asignar.</p>

                    <a href="{{route('asignaturas.relacionarasignaturas', ['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr']])}}" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded inline-block mt-4"><strong>Relacion</strong></a>
                    <a href="{{route('general.asignarasignatura')}}" class="asignar-btn bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded inline-block">Asignar</a>
                    <p class="error_msg"></p>
                    <h3>Filtros avanzados</h3>
                    <div class="search-area">
                        <span class="hide">checkbox</span>
                        <span class="hide">id</span>
                        <span >Asignatura</span>
                        <span>Codigo</span>
                        <span>Nivel</span>
                        <span>UC</span>
                        <span>Estado Plan</span>
                        <span class="hide">Accion</span>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="tabla-planes">
                        <thead>
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Asignatura</th>
                                <th>Codigo</th>
                                <th>Nivel</th>
                                <th>UC</th>
                                <th>Estado Plan</th>
                                <th>Accion</th>
                                <th>Version</th>
                            </tr>
                        </thead>
                        
                        @foreach ($asignaturas as $asignatura)
                            @if(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'a ')
                                <tr style="background-color: #3e8e3e; color: white">
                            @else
                                <tr>
                            @endif
                                <td><input type="checkbox" value="{{$asignatura->sdd090d_cod_asign}}"></td>
                                <td>{{$asignatura->id}}</td>
                                <td>{{$asignatura->sdd090d_nom_asign}}</td>
                                <td>{{$asignatura->sdd090d_cod_asign}}</td>
                                <td>{{$asignatura->sdd090d_nivel_asignatura}}</td>
                                <td>{{$asignatura->sdd090d_uc}}</td>
                                <td class="estado">
                                    {{-- @if(isset($asignatura->sdd210ds_estado))
                                    pp {{$asignatura->sdd210ds_estado}}
                                    @endif --}}
                                    @if(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'a ')
                                        Actual
                                        <a href="{{route('pdf.generarTematica', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign, 'version'=>$asignatura->sdd210ds_version])}}">PDF</a>
                                    @elseif(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'v ')
                                        Plan viejo
                                        <a href="{{route('pdf.generarTematica', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign, 'version'=>$asignatura->sdd210ds_version])}}">PDF</a>
                                    @elseif(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'ff')
                                        completo
                                    @else
                                        @if(isset($asignatura->sdd200d_estado))
                                            @if($asignatura->sdd200d_estado == 'a ')
                                            Asignado
                                            @elseif($asignatura->sdd200d_estado == 'c ')
                                            Creado por administrador
                                            @elseif($asignatura->sdd200d_estado == 'rs')
                                            En revision
                                            @elseif($asignatura->sdd200d_estado == 'rj')
                                            Pendiente por aprobacion
                                            @elseif($asignatura->sdd200d_estado == 'ff')
                                            Aprobado
                                            <a href="{{route('pdf.generarTematica', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign, 'version'=>1])}}">PDF</a>
                                            @endif
                                        @else
                                        Pendiente
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('general.plancrear', ['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'asignatura'=> $asignatura->sdd090d_cod_asign])}}">Revisar</a>
                                    {{-- @if($asignatura->sdd200d_estado)
                                    <a href="{{route('general.plancrear', ['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'asignatura'=> $asignatura->sdd090d_cod_asign])}}">Revisar</a>
                                    @else
                                    Crear
                                    @endif --}}
                                    @if($asignatura->sdd200d_estado)
                                    Asignado
                                    @else
                                    No asignado
                                    @endif
                                    @if($asignatura->sdd200d_estado == 'ff' || $asignatura->sdd210ds_estado == 'a ' || $asignatura->sdd210ds_estado == 'ff' || $asignatura->sdd210ds_estado =='a ')
                                    <p><a href="{{route('general.crearnuevaversionplan', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign])}}" class="cta_nueva_version">
                                        Nueva version</a></p>
                                    @endif
                                </td>
                                <td>{{$asignatura->sdd210ds_version}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script>
        asignar = document.querySelector('.asignar-btn')
        asignar.addEventListener('click', e=>{
            e.preventDefault()

            checked = document.querySelectorAll('[type=checkbox]:checked')

            if(checked.length <=0){
                document.querySelector('.error_msg').innerText = 'Primero seleccione al menos una asignatura'
            }else{
                console.log(e)
                console.log(e.target.getAttribute('href'))
                carrera = document.querySelector('.codigo_carrera').innerText
                lapso = document.querySelector('.lapso_vigencia').innerText
                ruta = `${e.target.getAttribute('href')}?lapso=${lapso}&carrera=${carrera}`
                
                console.log(checked)

                checked.forEach(element => {
                    console.log(element.value)
                    ruta+=`&asignatura[]=${element.value}`
                });
                console.log(ruta)
                window.location.href = ruta
            }
            

            
        })

        console.log(@json($asignaturas))

        $(document).ready(function () {
        // Setup - add a text input to each footer cell
        // $('#tabla-planes tfoot th').each(function (i) {
        //     var title = $('#tabla-planes thead th')
        //         .eq($(this).index())
        //         .text();
        //     $(this).html(
        //         '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
        //     );
        // });

        $('.search-area span').each(function (i) {
            var title = $('#tabla-planes thead th')
                .eq($(this).index())
                .text();
            $(this).html(
                '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
            );
        });
    
        // DataTable
        var table = $('#tabla-planes').DataTable({
            // scrollY: '400px',
            // scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            bAutoWidth : false
        });
    
        // Filter event handler
        // $(table.table().container()).on('keyup', 'tfoot input', function () {
        //     table
        //         .column($(this).data('index'))
        //         .search(this.value)
        //         .draw();
        // });

        $('#listarplanes').on('keyup', '.search-area input', function () {
            table
                .column($(this).data('index'))
                .search(this.value)
                .draw();
        });

        $('table colgroup').remove()
    });

    $('.cta_nueva_version').click(e=>{
        console.log('e')
    })
    </script>
</x-app-layout>