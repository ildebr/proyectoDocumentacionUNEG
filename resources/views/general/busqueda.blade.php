<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistema Documentacion - Busqueda</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{'css/style.css'}}">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/style.css'])
        {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" > --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        @stack('styles')
        @stack('head-scripts')

    <style>
        body{
            background: gray;
        }
    </style>
</head>
<body>
    <div class="py-12 mw-[600px] mx-auto" id="listarplanes">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Busqueda por plan
                    </h2>

                    
                    <p>
                        v = Programa viejo. a = Programa actual
                    </p>

                    <form action="">
                        @if(count($planes)>0)
                            <select name="plan" id="plan">
                                <option value=""></option>
                                @foreach ($planes as $plan)
                                    {{-- {{$plan->sdd100d_lapso}} --}}
                                    <option value="{{$plan->sdd100d_lapso}}--{{$plan->sdd080d_cod_carr}}">{{$plan->sdd100d_lapso}} - {{$plan->sdd080d_nom_carr}}</option>
                                @endforeach
                            </select>
                            

                        @else 
                            <p>No hay planes para seleccionar</p>
                        @endif
                    </form>


                    <div class="resultados-busqueda">
                        <div class="search-area">
                            <span class="rtl:text-left">Lapso</span>
                            <span class="text-left">Codigo del plan</span>
                            <span class="text-left">Codigo carrera</span>
                            <span class="text-left">Nombre de La carrera</span>
                            <span class="text-left">Estado</span>
                            <span class="text-left">Accion</span>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="tabla-planes">
                            <thead>
                                <tr>
                                    <th>Semestre</th>
                                    <th>Codigo</th>
                                    <th>Carrera</th>
                                    <th>Asignatura</th>
                                    <th>Estado</th>
                                    <th>Version</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <span class="loader-ele none"></span>
                        
                    </div>



                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Busqueda por hash
                    </h2>

                    <form class="hash-busqueda" action="">
                        <input type="text" name="hash" placeholder="hash" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full">

                        <div class="resultados"></div>
                    </form>




                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script>

// var table = $('#tabla-planes').DataTable({
//             // scrollY: '400px',
//             // scrollX: true,
//             scrollCollapse: true,
//             paging: false,
//             fixedColumns: true,
//             bAutoWidth : false
//             columns: [
//                         { data: 'semestre' },
//                         { data: 'codigo' },
//                         { data: 'estado' },
//                         { data: 'version'},
//                         { data: 'accion'}
//                     ],
//         });
        var route = '{{route('general.busquedaasignaturas', ['lapso'=>"rela",'carrera'=> "reca"])}}'
        console.log(route)
        $('select').on('change', e=>{
            var forms = new FormData()

            if($('#plan').val() == ''){
                return
            }

            $('.loader-ele').removeClass('none')


            
            var csrfToken = $('meta[name="csrf-token"]').attr('content')
            console.log($("#plan").val())
            var formatted = $("#plan").val()
            formatted = formatted.replaceAll(' ', '').split('--')
            console.log(formatted)

            newroute = route.replace('amp;','').replace('rela',formatted[0]).replace('reca',formatted[1])
            console.log(newroute)

            forms.append('lapso', formatted[0])
            forms.append('carrera', formatted[1])
            // '{{route('general.busqueda', ['lapso'=>1, 'carrera'=>1])}}'
            $.ajax({
                url: newroute,
                type: 'post',
                data: forms,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers:{ 
                    'X-CSRF-TOKEN':  csrfToken, 'Accept': 'application/json'},
                success: function(resp){
                    console.log('success')
                    console.log(resp)
                    // $('#cargar-relacion').removeClass('disable')
                    console.log(resp.data)
                    toastr.success('Datos cargados', 'Exito')
                    // table.clear()
                    // table.rows.add(resp.data);

                    if(resp.data){
                        $('.loader-ele').addClass('none')
                    }

                    var table = $('#tabla-planes').DataTable({
                        // scrollY: '400px',
                        // scrollX: true,
                        scrollCollapse: true,
                        paging: false,
                        fixedColumns: true,
                        bAutoWidth : false,
                        data: resp.data,
                        columns: [
                                    { data: 'sdd110d_semestre' },
                                    { data: 'sdd090d_cod_carr' },
                                    { data: 'sdd080d_nom_carr'},
                                    { data: 'sdd090d_nom_asign'},
                                    { data: 'sdd210ds_estado' },
                                    { data: 'sdd210ds_version'},
                                ],
                        columnDefs: [
                            {
                                targets:6,
                                sortable:false,
                                render: function(data, type, full, meta) {
                                console.log(full,'p')
                                http://127.0.0.1:7000/generate-pdf-tematica/201401/2072/1472208%20/1
                                return "<center>" +
                                        `<a class="text-blue-700 font-bold" href="/generate-pdf-tematica/${full.sdd210d_lapso_vigencia.replaceAll(' ','')}/${full.sdd090d_cod_carr}/${full.sdd090d_cod_asign.replaceAll(' ','')}/${parseInt(full.sdd210ds_version)}">PDF</a>`
                                    "</center>";
                        }
                            }
                        ]
                    });
                },
                error: function (data, textStatus, errorThrown) {
                    // $('#cargar-relacion').removeClass('disable')
                    console.log(data);
                    if(resp.data){
                        $('.loader-ele').addClass('none')
                    }
                    toastr.error('No hay planes cargados para esta asignatura en este plan' + textStatus + ' ' + errorThrown, 'Error')

                },
                done: function(){
                    // $('#cargar-relacion').removeClass('disable')
                }
            })

            
        })


        $(document).ready(e=>{
            

        $('#listarplanes').on('keyup', '.search-area input', function () {
            table
                .column($(this).data('index'))
                .search(this.value)
                .draw();
        });
        })

        
    </script>
</body>
</html>