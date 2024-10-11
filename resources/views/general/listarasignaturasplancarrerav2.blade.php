<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@latest/dist/css/shepherd.css" />
    @endpush
    <style>
        .hide{
            display: none;
        }
        .version__link{
            color: blue;
            font-weight: 600;
            font-size: 19px;
            text-decoration: underline;
        }

        .version__link.actual{
            text-decoration: none;
            color: black;
        }
    </style>
    <div class="py-12" id="listarplanes">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Lista de asignaturas 
                    </h2>

                    <input type="hidden" name="version-plan" id="version-valor" value="{{request()->route('version')}}">

                    @if(count($versiones) > 1)
                        <h3>Versiones disponibles</h3>
                        @foreach ($versiones as $version)
                            {{-- {{$version->sdd210ds_version}} --}}
                            @if((int)$version->sdd210ds_version == (int)request()->route('version'))
                                <a class="version__link actual" href="{{route('general.listarasignaturaslapsocarrerav2',['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'version' => (int)$version->sdd210ds_version ])}}">{{$version->sdd210ds_version}}</a>
                            @else
                                <a class="version__link" href="{{route('general.listarasignaturaslapsocarrerav2',['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'version' => (int)$version->sdd210ds_version ])}}">{{$version->sdd210ds_version}}</a>
                            @endif
                        @endforeach

                    @endif

                    

                    <p>Estas viendo las asignaturas de la carrera: <strong>{{$carrera['sdd080d_nom_carr']}}</strong>, codigo <strong class="codigo_carrera">{{$carrera['sdd080d_cod_carr']}}</strong> con el lapso de vigencia <strong class="lapso_vigencia">{{$lapso}}</strong> y version <strong>{{request()->route('version')}}</strong></p>

                    <p>Para asignar asignaturas a un profesor/coordinador selecciona las asignaturas primero y despues presiona el boton asignar.</p>

                    <a href="{{route('asignaturas.relacionarasignaturasv2', ['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'version'=>request()->route('version')])}}" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded inline-block mt-4" id="relacionar-button"><strong>Relacionar asignaturas</strong></a>
                    <a href="{{route('asignaturas.relacionartemasv2',['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'version'=>request()->route('version')])}}"  class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded inline-block mt-4" id="relacionar-temas-button">Relacionar temas de asignaturas</a>
                    <a href="{{route('general.asignarasignaturav2')}}" class="asignar-btn bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded inline-block" id="asignar-btn">Asignar</a>
                    <button class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded inline-block" id="tutorial-btn">Tutorial</button>
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
                                <th>Semestre</th>
                                <th>Asignatura</th>
                                <th>Codigo</th>
                                <th>Nivel</th>
                                <th>UC</th>
                                <th>Estado Plan</th>
                                <th>Accion</th>
                                <th>Version</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($asignaturas as $asignatura)
                                @if(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'a ')
                                    <tr style="background-color: #3e8e3e; color: white">
                                @elseif(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'v ')
                                    <tr style="background-color: #406240; color: white">
                                @else
                                    <tr>
                                @endif
                                    <td>
                                        @if((int)request()->route('version') == 1)
                                            <input type="checkbox" value="{{$asignatura->sdd090d_cod_asign}}">
                                        @elseif(isset($asignatura->sdd210ds_estado))
                                            <input type="checkbox" value="{{$asignatura->sdd090d_cod_asign}}">
                                        @else

                                        @endif
                                    </td>
                                    <td>{{$asignatura->id}}</td>
                                    <td>{{$asignatura->sdd110d_semestre}}</td>
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
                                            <a class="cta cta-primary"  href="{{route('pdf.generarTematica', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign, 'version'=>$asignatura->sdd210ds_version])}}">PDF</a>
                                        @elseif(isset($asignatura->sdd210ds_estado) && $asignatura->sdd210ds_estado == 'v ')
                                            Plan viejo
                                            <a class="cta cta-primary"  href="{{route('pdf.generarTematica', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign, 'version'=>$asignatura->sdd210ds_version])}}">PDF</a>
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
                                                <a class="cta cta-primary" href="{{route('pdf.generarTematica', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign, 'version'=>1])}}">PDF</a>
                                                @endif
                                            @else
                                            Pendiente
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if((int)request()->route('version') == 1 || isset($asignatura->sdd210ds_estado))
                                            @if (isset($asignatura->sdd210ds_estado))
                                                <a class="cta cta-primary mb-2" href="{{route('general.plandetalleeditar', ['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'asignatura'=> $asignatura->sdd090d_cod_asign, 'version'=> request()->route('version')])}}">Revisar</a>
                                            @else 
                                                <a class="cta cta-primary mb-2" href="{{route('general.plandetalleeditar', ['lapso'=>$lapso, 'carrera' => $carrera['sdd080d_cod_carr'], 'asignatura'=> $asignatura->sdd090d_cod_asign, 'version'=> request()->route('version')])}}">Crear</a>
                                            @endif
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
                                            <p><a class="cta cta-primary" href="{{route('general.crearnuevaversionplan', ['lapso'=>$lapso, 'carrera'=> $asignatura->sdd090d_cod_carr, 'asignatura'=>$asignatura->sdd090d_cod_asign])}}" class="cta_nueva_version">
                                                Nueva version</a></p>
                                            @endif
                                        @else

                                        @endif
                                    </td>
                                    <td>{{$asignatura->sdd210ds_version}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@latest/dist/js/shepherd.min.js"></script>
    <script>
        asignar = document.querySelector('.asignar-btn')
        asignar.addEventListener('click', e=>{
            e.preventDefault()

            checked = document.querySelectorAll('[type=checkbox]:checked')

            if(checked.length <=0){
                document.querySelector('.error_msg').innerText = 'Primero seleccione al menos una asignatura'
                toastr.error('Necesitas seleccionar al menos una asignatura para asignarla', 'Selecciona al menos una asignatura')
            }else{
                console.log(e)
                console.log(e.target.getAttribute('href'))
                carrera = document.querySelector('.codigo_carrera').innerText
                lapso = document.querySelector('.lapso_vigencia').innerText
                ruta = `${e.target.getAttribute('href')}?lapso=${lapso}&carrera=${carrera}&version=${$('#version-valor').val()}`
                
                console.log(checked)

                checked.forEach(element => {
                    console.log(element.value)
                    ruta+=`&asignatura[]=${element.value}`
                });
                console.log(ruta)
                window.location.href = ruta
                console.log(ruta)
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

    <script>
        const tour = new Shepherd.Tour({
            useModalOverlay: true,
            defaultStepOptions: {
                cancelIcon: {
                    enabled: true
                },
                classes: 'h2',
                scrollTo: { behavior: 'smooth', block: 'center' }
            }
        });
        // element: 'tbody tr:first-of-type a[href*="detalle"]',
        tour.addStep({
            title: 'Creacion de programas #1 - Introduccion',
            text: 'Para crear los programas de cada una de las asignaturas que conforman una carrera de un plan dado debemos pasar por varios pasos',
            attachTo: {
                element: 'h2',
                on: 'bottom'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        tour.addStep({
            title: 'Creacion de programas #2 - Asignaturas',
            text: 'Tenemos el listado de asignaturas de la carrera en el plan seleccionado a los cuales les crearemos los programas. Esta tabla contiene información sobre su ID, semestre, nombre, código, si ya ha sido asignado su creación, el estado en el que se encuentra, etc',
            attachTo: {
                element: 'table',
                on: 'top'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        tour.addStep({
            title: 'Creacion de programas #3 - Crear programa',
            text: 'Cada asignatura tiene al comienzo un botón de crear (una vez creado este botón pasará a ser editar). Al presionar este botón se te llevará a una página donde observarás el detalle de la asignatura donde podrás rellenar toda la información relacionada a este plan específico. Una vez esté completa la información en esta área tendrás la opción de crear una nueva versión y de imprimir el PDF.',
            attachTo: {
                element: 'tbody tr:first-of-type a[href*="detalle"]',
                on: 'top'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        tour.addStep({
            title: 'Creacion de programas #4 - Asignar',
            text: 'Para asignar la creación de un programa a un profesor/coordinador/otro solo necesitas marcar la o las casillas de las asignaturas que quieras asignar a una persona. Deberás repetir este proceso para cada usuario al que le quieras asignar uno o más programas.',
            attachTo: {
                element: 'tbody tr:first-of-type input[type="checkbox"]',
                on: 'top'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        tour.addStep({
            title: 'Creacion de programas #5 - Asignar',
            text: 'Una vez seleccionado la o las asignaturas que se desea asignar se presiona el botón de asignar que te redigira a una nueva pantalla donde deberas seleccionar el usuario al que asignaras la creación de los programas que seleccionaste.',
            attachTo: {
                element: '#asignar-btn',
                on: 'bottom'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        tour.addStep({
            title: 'Creacion de programas #6 - Relacionar asignaturas',
            text: 'En cualquier punto de la creacion de los programas de una carrera puedes dirigirte a la sección de relacionar asignaturas. En esta pantalla relacionaras las asignaturas de la carrera del plan en el que te ubiques. ',
            attachTo: {
                element: '#relacionar-button',
                on: 'bottom'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });
        tour.addStep({
            title: 'Creacion de programas #7 - Relacionar temas',
            text: 'Una vez completo todos los programas de las asignaturas y las relaciones de las asignaturas creadas puedes dirigirte a esta pantalla para relacionar los temas de las asignaturas.',
            attachTo: {
                element: '#relacionar-temas-button',
                on: 'bottom'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        
        tour.addStep({
            title: 'Creacion de programas #8 - Final',
            text: 'Una vez completado todo lo anterior habrás creado los programas de cada asignatura y terminado el proceso.',
            attachTo: {
                element: '#listarplanes',
                on: 'bottom'
            },
            useModalOverlay: true,
            buttons: [
                {
                    action() {
                        return this.back();
                    },
                    classes: 'shepherd-button-secondary',
                    text: 'Anterior'
                },
                {
                    action() {
                        return this.next();
                    },
                    text: 'Siguiente'
                }
            ],
            id: 'creating'
        });

        $('#tutorial-btn').click(e=>{
            tour.start();
        })
        
    </script>
</x-app-layout>