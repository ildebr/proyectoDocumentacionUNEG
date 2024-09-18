

<style>
    .relaciontemas_asignatura__contenedor{
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-bottom: 2rem;
        margin-top: 1rem;
    }
    .relaciontemas_asignatura__contenedor h3{
        font-size: 1.5rem;
        font-weight: 700;
    }

    .relaciontemas_asignatura__contenedor h4{
        font-size: 1.25rem;
        font-weight: 600;
        color: rgb(57, 57, 57);
    }

    h5.relaciontemas_relacionado_nombre{
        font-size: 1.1rem;
        font-weight: 600;
        color: rgb(19, 19, 19);
    }

    .relaciontemas_asignatura__temas__contenedor{
        margin-bottom: .5rem;
    }

    .relaciontemas_asignatura__temarelacionadounidad{
        background-color: rgb(29, 165, 228);
        width: fit-content;
        color: white;
        font-weight: 700;
        
        /* padding: .25rem; */
        border-radius: 4px;
        margin-bottom: .25rem;
        display: inline-block;
        overflow: hidden;

        display: grid;
        grid-template-columns: auto 18px;
        align-items: center;
        justify-content: center;
    }

    .relaciontemas_asignatura__temarelacionadounidad > *{
        padding: .2rem;
        display: inline-block;
        font-size: 14px;

    }
    .relaciontemas_asignatura__temarelacionadounidad .eliminar, .relaciontemas_relacionado_tema_eliminar{
        background-color: black;
        font-weight: 800;
        cursor: pointer;
        color: white;
        cursor: pointer;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .relaciontemas_asignatura__temarelacionadounidad .eliminar:hover{
        background-color: rgb(48, 48, 48);
    }

    .relaciontemas_relacionado_tema{
        background-color: #a0e53d;
        width: fit-content;
        margin-bottom: .1rem;
        margin-right: .1rem;
        font-weight: 700;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
    }
    .relaciontemas_relacionado_tema > *{
        padding: .3rem;
    }

    .relaciontemas_relacionado_tema{
        display: inline-block;
    }

    /* .relaciontemas_relacionado_tema_eliminar{
        background-color: black;
        color: white;
    } */

    .relaciontemas_asignatura__tema{
        cursor: pointer;
    }

     .relaciontemas_asignatura__tema.relaciontemas_asignatura__tema--activo h4::after{
        content: 'seleccionado';
        background-color: red;
        padding: .25rem;
        border-radius: 6px;
        color: white;
        font-size: 11px;
        display: inline;
     }

     .red{
        background: red;
     }

     button.disable{
        background-color: gray !important;
        pointer-events: none;
    }

    .loading{
        z-index: 10000;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(2px);
        display: flex;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .loading svg{
        max-height: 200px;
    }

    .loading.listo{
        display: none;
    }
</style>
<x-app-layout>
    <div class="py-12" id="relacionartemasasignaturaspage">
        <div class="loading">
            <p>CARGANDO</p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle fill="#191471" stroke="#191471" stroke-width="15" r="15" cx="40" cy="65"><animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="#191471" stroke="#191471" stroke-width="15" r="15" cx="100" cy="65"><animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="#191471" stroke="#191471" stroke-width="15" r="15" cx="160" cy="65"><animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a class="volver-link" href="{{ route('general.listarasignaturaslapsocarrera', ['lapso'=>request()->route('lapso'), 'carrera'=>request()->route('carrera')])}}">Volver a la vista general del plan</a>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Relacionar temas de asignaturas
                    </h2>
                    <p>Estas viendo los temas de las asignaturas de la carrera: <strong>{{$carrera['sdd080d_nom_carr']}}</strong> y codigo <strong>{{$carrera['sdd080d_cod_carr']}}</strong> con el lapso de vigencia <strong>{{$lapso}}</strong>.</p>


                    {{-- <div class="relaciontemas__contenedor">
                        <div class="relaciontemas_asignatura__contenedor">

                            <div class="relaciontemas_mitad">
                                <h3 class="relacion_asignatura_nombre">
                                    Matematica I
                                </h3>
    
                                <div class="relaciontemas_asignatura_relaciones_contenedor">
                                    <div class="relaciontemas_asignatura__temas__contenedor">
                                        <div class="relaciontemas_asignatura__tema">
                                            <h4>Nombre del Tema 1</h4>
                                        </div>
                                        <div class="relaciontemas_asignatura__temasrelacionados">
                                            <div class="relaciontemas_asignatura__temarelacionadounidad">
                                                <span>Tema 2 matematica</span>
                                                <span class="eliminar">X</span>
                                            </div>
                                            <div class="relaciontemas_asignatura__temarelacionadounidad">
                                                <span>Tema 3 estadistica</span>
                                                <span class="eliminar">X</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="relaciontemas_asignatura__temas__contenedor">
                                        <div class="relaciontemas_asignatura__tema">
                                            <h4>Nombre del Tema 2</h4>
                                        </div>
                                        <div class="relaciontemas_asignatura__temasrelacionados">
                                            
                                            <p>Tema 2 matematica I</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relaciontemas_mitad">
                                <p>Asingaturas relacionads</p>
                                <div class="relaciontemas_relacionado_contenedor">
                                    <h5 class="relaciontemas_relacionado_nombre">
                                        Estadistica I
                                    </h5>
                                    <div class="relaciontemas_relacionado_temas">
                                        <div class="relaciontemas_relacionado_tema">
                                            <span>laplace</span>
                                            
                                        </div>
                                        <p class="relaciontemas_relacionado_tema">
                                            Tema 2
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                    {{-- {{Str::replace("sample", "new", 'sample ppppera')}} --}}

                    @foreach($asignaturas as $asignatura)
                        <div class="relaciontemas_asignatura__contenedor" id="asignatura-{{ Str::replace(" ", "", $asignatura->sdd090d_cod_asign) }}" data-asignatura-nombre="{{$asignatura->sdd090d_nom_asign}}">

                            <div class="relaciontemas_mitad">
                                <h3 class="relacion_asignatura_nombre">
                                    {{$asignatura->sdd090d_nom_asign}}
                                </h3>

                                <div class="relaciontemas_asignatura_relaciones_contenedor">
                                    {{-- <div class="relaciontemas_asignatura__temas__contenedor">
                                        <div class="relaciontemas_asignatura__tema">
                                            <h4>Nombre del Tema 1</h4>
                                        </div>
                                        <div class="relaciontemas_asignatura__temasrelacionados">
                                            <div class="relaciontemas_asignatura__temarelacionadounidad">
                                                <span>Tema 2 matematica</span>
                                                <span class="eliminar">X</span>
                                            </div>
                                            <div class="relaciontemas_asignatura__temarelacionadounidad">
                                                <span>Tema 3 estadistica</span>
                                                <span class="eliminar">X</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="relaciontemas_mitad">
                                <p>Asingaturas relacionads</p>
                                <div class="relaciontemas_relacionado_contenedor">
                                    {{-- <div class="relaciontemas_relacionado_contenedor__interno">
                                        <h5 class="relaciontemas_relacionado_nombre">
                                            Estadistica I
                                        </h5>
                                        <div class="relaciontemas_relacionado_temas">
                                        
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                        </div>
                    @endforeach

                    <button id="cargar-relacion" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Subir relacion entre asignaturas</button>
                </div>

            </div>

            
        </div>
    </div>


    <script>
        var temas = @json($temas);
        var asignaturasrelacionadas = @json($asignaturasrelacionadas);
        var relacionesexistentes = @json($temasrelacionados)
        // console.log( @json($temas));
        console.log(relacionesexistentes);
        // console.log(@json($asignaturas))
        // console.log(@json($asignaturasrelacionadas));

        // primero se cargan las asignaturas relacionadas de cada asignatura
        asignaturasrelacionadas.map(ele =>{
            // se reemplaza el caracter vacio al final por 
            cod = ele.sdd095_cod_asign.replace(' ', '')
            codrelacion = ele.sdd095_asignatura_relacion_cod.replace(' ', '')
            $(`#asignatura-${cod} .relaciontemas_relacionado_contenedor`).append(`
                <div class="relaciontemas_relacionado_contenedor__interno asignaturaderelacionhijo-${codrelacion}" id="asignaturaderelacionhijo-${codrelacion}">
                    <h5 class="relaciontemas_relacionado_nombre">
                        ${ele.sdd095_asignatura_relacion_nombre}
                    </h5>
                    <div class="relaciontemas_relacionado_temas">
                        <div class="relaciontemas_relacionado_tema">
                            
                        </div>
                    </div>
                </div>
            `)
        })


        // segundo se cargan los temas de las asignaturas relacionadas para formar la lista a escoger

        temas.map(ele=>{
            
            $(`.asignaturaderelacionhijo-${ele.sdd215d_cod_asign.replace(' ','')} .relaciontemas_relacionado_temas`).append(`
                <div class="relaciontemas_relacionado_tema" data-tema-asignatura="${ele.sdd215d_cod_asign.replace(' ','')}" data-tema-id="${ele.id}">
                    <span>${ele.sdd215ds_nombre_tema}</span>
                </div>
            `)

            $(`#asignatura-${ele.sdd215d_cod_asign.replace(' ','')} .relaciontemas_asignatura_relaciones_contenedor`).append(`
                <div class="relaciontemas_asignatura__temas__contenedor" data-tema-id="${ele.id}" data-asignatura="${ele.sdd215d_cod_asign.replace(' ','')}">
                    <div class="relaciontemas_asignatura__tema">
                        <h4>${ele.sdd215ds_nombre_tema}</h4>
                    </div>
                    <div class="relaciontemas_asignatura__temasrelacionados">
                    </div>
                </div>
            `)

        })

        //a;adir los temas
        // temas.map(ele=>{
            
        // })


        //seleccionar un tema al que le quieres relacionar temas
        // esto lo pone en el estado seleccionado
        $('.relaciontemas_asignatura__contenedor').on('click', '.relaciontemas_asignatura__tema h4', e=>{
            console.log(e)
            $('.relaciontemas_asignatura__tema.relaciontemas_asignatura__tema--activo').removeClass('relaciontemas_asignatura__tema--activo')
            $(e.currentTarget).parent().addClass('relaciontemas_asignatura__tema--activo')
            $(e.currentTarget).closest('.relaciontemas_asignatura__contenedor').addClass('relaciontemas_asignatura__contenedor--activo')
        })

        // selecciona un tema para relacionar 
        $('#relacionartemasasignaturaspage').on('click', '.relaciontemas_asignatura__contenedor--activo .relaciontemas_relacionado_tema', e=>{
            console.log(e.currentTarget.innerText)

            existe = $('.relaciontemas_asignatura__tema--activo')
            .closest('.relaciontemas_asignatura__temas__contenedor')
            .find(`.relaciontemas_asignatura__temarelacionadounidad[data-tema-id="${e.currentTarget.getAttribute('data-tema-id')}"]`)

            if(existe.length > 0){
                toastr.error('Los temas ya estan relacionados')
                return
            }

            nomasignatura= $(e.currentTarget).closest('.relaciontemas_relacionado_contenedor__interno').find('.relaciontemas_relacionado_nombre').text()
            $('.relaciontemas_asignatura__tema--activo').parent().find('.relaciontemas_asignatura__temasrelacionados').append(`
                <div class="relaciontemas_asignatura__temarelacionadounidad" data-tema-asignatura="${e.currentTarget.getAttribute('data-tema-asignatura')}" data-tema-id="${e.currentTarget.getAttribute('data-tema-id')}">
                    <span> <span class="relaciontemas_asignatura__temarelacionadounidad_nomasignatura">${nomasignatura}</span> | <span class="relaciontemas_asignatura__temarelacionadounidad__nomtema"> ${e.currentTarget.innerText} </span> </span>
                    <span class="eliminar">X</span>
                </div>
            `)
        })


        $('.relaciontemas_asignatura__contenedor').on('click', '.relaciontemas_asignatura__temarelacionadounidad .eliminar', e=>{
            console.log('click')
            $(e.currentTarget).parent().remove()
        })

        var relacionadosaenviar = []
        let counter = 0

        function obtenerRelacionesListado(){
            relacionadosaenviar = []
            counter = 0
            // cada uno de las asignaturas 
            temapadre = document.querySelectorAll('.relaciontemas_asignatura__temas__contenedor')
            
            
            // se itera por cada asignatura y se selecciona una asignatura padre
            temapadre.forEach(ele=>{
                var temapadreId = ele.getAttribute('data-asignatura')
                var innerelements = []
                var nombreTemaPadre = ele.querySelector('.relaciontemas_asignatura__tema').innerText
                var nombreAsignaturaPadre = $(ele).closest('.relaciontemas_asignatura__contenedor').attr('data-asignatura-nombre')
                // se seleccionan los temas con los que esta relacionado
                temasinternos= ele.querySelectorAll('.relaciontemas_asignatura__temarelacionadounidad')

                // si la asignatura tiene al menos una relacion entra en el iterador
                if(temasinternos.length > 0){
                    temasinternos.forEach(iele=>{
                        innerelements.push({
                            asignatura: iele.getAttribute('data-tema-asignatura'),
                            temaId: Number(iele.getAttribute('data-tema-id')),
                            asignaturaNombre: iele.querySelector('.relaciontemas_asignatura__temarelacionadounidad_nomasignatura').innerText,
                            temaNombre: iele.querySelector('.relaciontemas_asignatura__temarelacionadounidad__nomtema').innerText
                        })
                        counter++
                    })

                    // se agregan al arreglo que se le pasara al backend con los datos de la asignatura padre
                    // posicion = relacionadosaenviar.findIndex(asignatura => asignatura.asignaturapadre == temapadreId)
                    relacionadosaenviar.push({
                        asignaturaPadre: ele.getAttribute('data-asignatura'),
                        asignaturaPadreNombre: nombreAsignaturaPadre,
                        temaId: Number(ele.getAttribute('data-tema-id')),
                        temaPadreNombre: nombreTemaPadre,
                        relaciones: innerelements
                    })
                }
                

            })


            console.log(relacionadosaenviar)

            return relacionadosaenviar
        }

        

        //envia las relaciones al backend
        function enviarData(){
            // console.log(JSON.stringify(data))
            datum = obtenerRelacionesListado()
            // console.log(datum)
            // datum.push({'_token': $('#token').val()})
            // console.log(JSON.stringify(datum))

            if(counter == 0){
                toastr.error('Crea al menos una relacion', 'Error')
                $('#cargar-relacion').removeClass('disable')
                return
            }

            var forms = new FormData()
            forms.append('data', JSON.stringify(datum))
            var csrfToken = $('meta[name="csrf-token"]').attr('content')

            $.ajax({
                url: '{{route('asignaturas.relacionartemas', ['lapso'=>request()->route('lapso'), 'carrera'=>request()->route('carrera')])}}',
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
                    toastr.success('Datos cargados exitosamente. La pagina se actualizara en 3 segundos.', 'Exito')

                    setTimeout(()=>{
                        location.reload()
                    }, 3000)
                },
                error: function (data, textStatus, errorThrown) {
                    $('#cargar-relacion').removeClass('disable')
                    console.log(data);
                    toastr.error('Error al cargar los datos ' + textStatus + ' ' + errorThrown, 'Error')

                },
                done: function(){
                    $('#cargar-relacion').removeClass('disable')
                }
            })
        }

        $('#cargar-relacion').click(e=>{

            $('#cargar-relacion').addClass('disable')
            enviarData();
        })

        $(document).ready((e)=>{
            // se cargan las relaciones del sistema
            relacionesexistentes.map(ele =>{
                console.log(ele)
                // $(`.asigrelbox__selected__container[data-cod_asignatura="${ele.sdd095_cod_asign}"]`).append(`<div asignatura_id="" data-cod_asignatura="${ele.sdd095_asignatura_relacion_cod}" class="relacion">${ele.sdd095_asignatura_relacion_nombre}<span class="relacion__deletebtn">X</span></div>`)

                $(`[data-tema-id="${ele.sdd216d_id_tema_asignatura_principal}"][data-asignatura="${ele.sdd216d_cod_asign.replace(' ','')}"] .relaciontemas_asignatura__temasrelacionados`)
                .append(`
                    <div class="relaciontemas_asignatura__temarelacionadounidad" data-tema-asignatura="${ele.sdd216d_nom_tema_asignatura_relacion}" data-tema-id="${ele.sdd216d_id_tema_asignatura_relacion}">
                        <span> <span class="relaciontemas_asignatura__temarelacionadounidad_nomasignatura">${ele.sdd216d_nom_asignatura_relacion}</span> | <span class="relaciontemas_asignatura__temarelacionadounidad__nomtema"> ${ele.sdd216d_nom_tema_asignatura_relacion} </span> </span>
                        <span class="eliminar">X</span>
                    </div>
                `)
            })

            $('.loading').addClass('listo');
        })

        

    </script>
</x-app-layout>