@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
@endsection

<style>
    .asigrelbox__selected__container{
        display: flex;
        gap: .5rem;
        flex-direction: column;   
    }

    .relacion{
        width: fit-content;
        padding-left: .2rem;
        padding-right: .2rem;
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
    }

    .loading.listo{
        display: none;
    }

    .loading p{
        margin-top: 2rem;
    }

    .volver-link{
        color: blue !important;
    }
</style>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="loading">
                <p>CARGANDO</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a class="volver-link" href="{{ route('general.listarasignaturaslapsocarrera', ['lapso'=>request()->route('lapso'), 'carrera'=>request()->route('carrera')])}}">Volver a la vista general del plan</a>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Relacionar asignaturas
                    </h2>

                    <form action="{{route('asignaturas.relacionarasignaturas', ['lapso'=>request()->route('lapso'), 'carrera'=>request()->route('carrera')])}}">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    </form>

                    <p>Estas viendo las asignaturas de la carrera: <strong>{{$carrera['sdd080d_nom_carr']}}</strong> y codigo <strong>{{$carrera['sdd080d_cod_carr']}}</strong> con el lapso de vigencia <strong>{{$lapso}}</strong>.</p>


                    <div class="asigrelbox">
                        @foreach ($asignaturas as $asignatura)
                            <div class="asigrelbox__item grid grid-cols-2 gap-2">
                                <header class="asigrelbox__header">
                                    <h3 class="text-gray-700 text-m"><strong>{{$asignatura->sdd090d_nom_asign}}</strong></h3>
                                </header>

                                <div class="asigrelbox__searchbox">
                                    <h4>Buscar asignatura para relacionar</h4>
                                    <input data-autocompleteinput='{{$asignatura->id}}' placeholder="Buscar asignatura" style="background-image: url({{URL::to('/')}}/images/search.svg)" class="buscar-asignatura asignatura-search-input" type="text" name="asignatura">
                                    {{-- <button>Buscar</button> --}}
                                    <div class="asigrelbox__results">
                                        <ul class="autocomplete" data-autocompletebox='{{$asignatura->id}}'></ul>
                                    </div>
                                </div>
                                <div class="asigrelbox__selected">
                                    <div class="asigrelbox__selected__container" data-nom_asignatura_padre='{{$asignatura->sdd090d_nom_asign}}' data-cod_asignatura='{{$asignatura->sdd090d_cod_asign}}' data-box='{{$asignatura->id}}' id="box-{{$asignatura->id}}"></div>
                                </div>
                            </div>
                        @endforeach
                        
                        <button id="cargar-relacion" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Subir relacion</button>
                    </div>

                </div>
            </div>
        </div>
        
    </div>

    

    

    <script>

        var arr = @json($asignaturas);
        var relacionesexistentes = @json($relacion);
        console.log(relacionesexistentes)
        console.log(arr)

        $(document).ready((e)=>{
            relacionesexistentes.map(ele =>{
                console.log(ele)
                $(`.asigrelbox__selected__container[data-cod_asignatura="${ele.sdd095_cod_asign}"]`).append(`<div asignatura_id="" data-cod_asignatura="${ele.sdd095_asignatura_relacion_cod}" class="relacion">${ele.sdd095_asignatura_relacion_nombre}<span class="relacion__deletebtn">X</span></div>`)
            })

            $('.loading').addClass('listo');
        })


        //buscador
        $(".asignatura-search-input").on("keyup", e=>{
            text = e.target.value.toLowerCase()
            id = e.target.getAttribute('data-autocompleteinput')

            //filtramos los que tengan nombres parecidos
            results = arr.filter( ele => ele.sdd090d_nombre_largo.toLowerCase().includes(text)  )

            //vaciamos la lista para agregar los nuevos resultados
            $(`[data-autocompletebox=${id}]`).empty()

            //agregamos los datos a la caja de autocompletar
            results.map(result =>{
                container = document.createElement('div')
                container.textContent = result.sdd090d_nom_asign
                container.className = 'searchbox__result__element'
                container.setAttribute('result_element_id', result.id)
                container.setAttribute('data-cod_asignatura', result.sdd090d_cod_asign)
                container.setAttribute(`data-searchparentelement`,id)
                $(`[data-autocompletebox=${id}]`).append(container)
            })
            
            
        })

        // cuando seleccionamos un elemento de la caja de autocompletar lo agregamos a la caja de seleccionadosny vaciamos el buscador
        $('[data-autocompletebox]').on('click', '.searchbox__result__element',e=>{


            console.log(e)
            // elemento q contiene la asignatura de la relacion
            container = document.createElement('div')
            container.textContent = e.target.innerText
            container.setAttribute('asignatura_id', e.target.getAttribute('result_element_id'))
            container.setAttribute('data-cod_asignatura', e.target.getAttribute('data-cod_asignatura'))
            container.className = 'relacion'

            closebtn = document.createElement('span')
            closebtn.textContent = 'X'
            closebtn.className = 'relacion__deletebtn'

            container.appendChild(closebtn)
            $(`[data-box=${e.target.getAttribute('data-searchparentelement')}]`).append(container)
            console.log(e.target.getAttribute('result_element_id'))
            console.log(e.target.getAttribute('data-searchparentelement'))
            console.log(e.target.getAttribute('data-cod_asignatura'))
            console.log($(`[data-autocompleteinput=${e.target.getAttribute('data-searchparentelement')}]`))
            $(`[data-autocompleteinput=${e.target.getAttribute('data-searchparentelement')}]`).val('')

        })

        $('.asigrelbox__selected').on('click', '.relacion__deletebtn', e=>{
            //eliminar relacion
            console.log(e)
            $(e.currentTarget).parent().remove()
        })

        // la caja de resultados de la busqueda se muestra al hacer click sobre el buscador
        $(".asignatura-search-input").on("focus", e=>{
            
            $(`[data-autocompletebox=${e.target.getAttribute('data-autocompleteinput')}]`).css("display", "block");
        })

        // y se vacia cuando pierde el foco
        $(".asignatura-search-input").on("focusout", e=>{
            setTimeout(() => {
                $(`[data-autocompletebox=${e.target.getAttribute('data-autocompleteinput')}]`).css("display", "none");
            }, 350);
        })


        let data = []
        let counter = 0

        //funcion para obtener toda la informacion de la caja de relaciones y formatearla en un arreglo de objetos, los objetos cada relacion
        function getAllData(){
            counter = 0
            data = []
            boxes = document.querySelectorAll('.asigrelbox__selected__container')
            // console.log(boxes)
            boxes.forEach((element, idx) => {
                // codigo de la asignatura de esta iteracion
                actual = element.getAttribute('data-cod_asignatura')

                // se crea un objeto para tener relacion de la asginatura y las asignaturas de su relacion
                innerData = {}
                innerData.asignatura = actual
                innerData.nombre = element.getAttribute('data-nom_asignatura_padre')
                
                innerData.relacion = []
                // console.log(element)
                relacion = element.querySelectorAll('.relacion')
                // console.log(element.querySelectorAll('.relacion'))
                // innerData.nombre = relacion.innerText.slice(0,-1)
                // console.log(relacion)
                console.log(relacion.innerText)
                relacion?.forEach(ele=>{
                    innerData.relacion.push({id: ele.getAttribute('data-cod_asignatura'), nombre: ele.textContent.slice(0,-1)})
                    ++counter
                })

                data.push(innerData)
                return true;
            });

            console.log(data)
            return data
        }


        //envia las relaciones al backend
        function enviarData(){
            // console.log(JSON.stringify(data))
            datum = getAllData()
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
                url: '{{route('asignaturas.relacionarasignaturass', ['lapso'=>request()->route('lapso'), 'carrera'=>request()->route('carrera')])}}',
                // url: "http://127.0.0.1:8000/201401/2072/relacion/crearr",
                type: 'post',
                // data: JSON.stringify(formatedData),
                // data: form,
                // data: {
                //     data: datum
                // },
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
                    $('#cargar-relacion').removeClass('disable')
                    toastr.success('Datos cargados exitosamente. La pagina se actualizara en 3 segundos.', 'Exito')

                    setTimeout(()=>{
                        location.reload()
                    }, 4000)
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



    </script>
</x-app-layout>