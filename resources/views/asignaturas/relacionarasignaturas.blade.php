<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Lista de asignaturas
                    </h2>

                    <p>Estas viendo las asignaturas de la carrera: <strong>{{$carrera['sdd080d_nom_carr']}}</strong> y codigo <strong>{{$carrera['sdd080d_cod_carr']}}</strong> con el lapso de vigencia <strong>{{$lapso}}</strong></p>

                    <div class="asigrelbox">
                        @foreach ($asignaturas as $asignatura)
                            <div class="asigrelbox__item grid grid-cols-2 gap-2">
                                <header class="asigrelbox__header">
                                    <h3 class="text-gray-700 text-m"><strong>{{$asignatura->sdd090d_nom_asign}}</strong></h3>
                                </header>

                                <div class="asigrelbox__searchbox">
                                    <h4>Buscar asignatura para relacionar</h4>
                                    <input data-autocompleteinput='{{$asignatura->id}}' placeholder="Buscar asignatura" style="background-image: url({{URL::to('/')}}/images/search.svg)" class="buscar-asignatura asignatura-search-input" type="text" name="asignatura">
                                    <button>Buscar</button>
                                    <div class="asigrelbox__results">
                                        <ul class="autocomplete" data-autocompletebox='{{$asignatura->id}}'></ul>
                                    </div>
                                </div>
                                <div class="asigrelbox__selected">
                                    <div class="asigrelbox__selected__container" data-box='{{$asignatura->id}}' id="box-{{$asignatura->id}}"></div>
                                </div>
                            </div>
                        @endforeach

                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Subir relacion</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        var arr = @json($asignaturas);
        console.log(arr)
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
                container.setAttribute(`data-searchparentelement`,id)
                $(`[data-autocompletebox=${id}]`).append(container)
            })
            
            
        })

        // cuando seleccionamos un elemento de la caja de autocompletar lo agregamos a la caja de seleccionadosny vaciamos el buscador
        $('[data-autocompletebox]').on('click', '.searchbox__result__element',e=>{
            container = document.createElement('div')
            container.textContent = e.target.innerText
            container.className = 'relacion'

            closebtn = document.createElement('span')
            closebtn.textContent = 'X'
            closebtn.className = 'relacion__deletebtn'

            container.appendChild(closebtn)
            $(`[data-box=${e.target.getAttribute('data-searchparentelement')}]`).append(container)
            console.log(e.target.getAttribute('data-searchparentelement'))
            console.log($(`[data-autocompleteinput=${e.target.getAttribute('data-searchparentelement')}]`))
            $(`[data-autocompleteinput=${e.target.getAttribute('data-searchparentelement')}]`).val('')

        })

        $('.asigrelbox__selected').on('click', '.relacion__deletebtn', e=>{
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

    </script>
</x-app-layout>