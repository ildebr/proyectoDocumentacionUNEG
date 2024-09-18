<x-app-layout>

    <style>
        .form-grid{
            display: grid; grid-template-columns: 32% 32% 32%; gap: 1%
        }
    </style>

    



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Carga de plan de la asignatura: <strong>{{$asignatura->sdd090d_nom_asign}} del lapso <strong>{{request()->route('lapso')}}</strong></strong>
                    </h2>
                    
                    <form  class="plan_formulario">
                    <h3 class="mt-2 mb-2"><strong>Informacion General</strong></h3>

                    <input type="hidden" name="version_plan" value="{{request()->route('version')}}">

                    <div class="form-grid grid grid-cols-3 gap-4 mb-4" style="">
                        <div>
                            <label for="codigo">Codigo </label>
                            <input  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" type="text" name="codigo" value='{{$asignatura->sdd090d_cod_asign}}'>
                            <div class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full">
                                {{$asignatura->sdd090d_cod_asign}}
                            </div>
                        </div>
                        <div>
                            <label for="uc">Unidad de credito</label>
                            <input  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" type="text" name="uc" value={{$asignatura->sdd090d_uc}}>
                            <div class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full">
                                {{$asignatura->sdd090d_uc}}
                            </div>
                        </div>
                        <div>
                            <label for="had">HAD</label>
                            <input  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" type="text" name="had">
                        </div>
                        <div>
                            <label for="cf">Componente de formacion</label>
                            <select  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="cf" id="cf">
                                <option value=""></option>
                                <option value="g">General</option>
                            </select>
                        </div>
                        <div>
                            <label for="caracter">Caracter</label>
                            <select  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="caracter" id="caracter">
                                <option value=""></option>
                                <option value="g">Obligatorio</option>
                                <option value="e">Electiva</option>
                            </select>
                        </div>
                    </div>
                    <label for="comp_form">Componente de formacion
                        <select  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_form" id="comp_form">
                            <option value=""></option>
                            <option value="g">General</option>
                            <option value="b">Profesional basica</option>
                            <option value="e">Profesional especializada</option>
                            <option value="p">Practica profesional</option>
                            <option value="s">Pasantia</option>
                        </select>
                    </label>

                    <label class="mt-6" for="proposito">Proposito
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="proposito" id="proposito" cols="30" rows="10">{{$plan->sdd210ds_as_proposito}}</textarea>
                    </label>
                    <label class="mt-6" for="capacidades">Capacidades a desarrollar (tematica)
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="capacidades" id="capacidades" cols="30" rows="10">{{$plan->sdd210ds_r_capacidades}}</textarea>
                        <div id="capacidades-text"></div>
                        
                    </label>
                    <label class="mt-6" for="habilidades">Habilidades a desarrollar (tematica)
                        <div id="habilidades-text"></div>
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="habilidades" id="habilidades" cols="30" rows="10">{{$plan->sdd210ds_r_habilidades}}</textarea>
                    </label>
                    <label class="mt-6" for="capacidades_profesionales_tematica">Capacidades profesionales (tematica)
                        <div id="capacidades_profesionales_tematica-text"></div>
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="capacidades_profesionales_tematica" id="capacidades_profesionales_tematica" cols="30" rows="10">{{$plan->sdd210ds_r_capacidades_profesionales}}</textarea>
                    </label>
                    <label class="mt-6" for="red_tematica">Red tematica (tematica)
                        <div id="red_tematica-text"></div>
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="red_tematica" id="red_tematica" cols="30" rows="10">{{$plan->sdd210ds_r_red_tematica}}</textarea>
                    </label>
                    <label class="mt-6" for="descripcion_red_tematica">Descripcion de la red tematica (tematica)
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="descripcion_red_tematica" id="descripcion_red_tematica" cols="30" rows="10">{{$plan->sdd210ds_r_descripcion_red_tematica}}</textarea>
                    </label>
                    <label class="mt-6 block" for="comp_genericas">Competencias genericas de un estudiante UNEG
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_genericas" id="comp_genericas" cols="30" rows="10">{{$plan->sdd210ds_as_competencias_genericas}}</textarea>
                    </label>
                    <label class="mt-6 block" for="comp_profesionales">Competencias Profesionales (texto corto)
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_profesionales" id="comp_profesionales" cols="30" rows="10">{{$plan->sdd210ds_a_competencias_profesionales}}</textarea>
                    </label>
                    <label class="mt-6 block" for="comp_profesionales_basicas">Competencias Profesionales Basicas
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_profesionales_basicas" id="comp_profesionales_basicas" cols="30" rows="10">{{$plan->sdd210ds_s_competencias_profesionales_basicas}}</textarea>
                    </label>
                    <label class="mt-6 block" for="comp_profesionales_especificas">Competencias Profesionales Especificas
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_profesionales_especificas" id="comp_profesionales_especificas" cols="30" rows="10">{{$plan->sdd210ds_s_competencias_profesionales_especificas}}</textarea>
                    </label>
                    <label class="mt-6 block" for="comp_unidad_curricular">Competencias de la Unidad Curricular
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_unidad_curricular" id="comp_unidad_curricular" cols="30" rows="10">{{$plan->sdd210ds_a_competencias_unidad_curricular}}</textarea>
                    </label>
                    <label class="mt-6 block" for="temario">Temario
                        <div class="options-controller" data-option-controller='temario'>
                            <div class="options-container" data-option-container='temario'>
    
                            </div>
    
                            <input type="text" class="options-input border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" data-option-input="temario" placeholder="Ingresa un tema">
                            <button type="button" class="options-cta inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-2" data-option-button="temario">Añadir tema</button>
                        </div>
                    </label>
                    <label class="mt-6 block" for="sinopsis_de_tema">Sinopsis de contenido del Tema

                        <div class="options-extend-container" data-option-expand='temario'>

                        </div>

                    </label>
                    <label class="mt-6 block" for="valores_actitudes">Valores y actitudes
                        <div id="valores_actitudes-text"></div>
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="valores_actitudes" id="valores_actitudes" cols="30" rows="10">{{$plan->sdd210ds_a_valores_actitudes}}</textarea>
                    </label>
                    <label class="mt-6 block" for="estrategias_didacticas">Estrategias Didacticas
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="estrategias_didacticas" id="estrategias_didacticas" cols="30" rows="10">{{$plan->sdd210ds_as_estrategias_didacticas}}</textarea>
                    </label>
                    <label class="mt-6 block" for="estrategias_docentes">Estrategias Docentes
                        <div id="estrategias_docentes-text"></div>
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="estrategias_docentes" id="estrategias_docentes" cols="30" rows="10">{{$plan->sdd210ds_as_estrategias_docentes}}</textarea>
                    </label>
                    <label class="mt-6 block" for="estrategias_aprendizaje">Estrategias De Aprendizaje
                        <div id="estrategias_aprendizaje-text"></div>
                        <textarea style="display: none" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="estrategias_aprendizaje" id="estrategias_aprendizaje" cols="30" rows="10">{{$plan->sdd210ds_as_estrategias_aprendizajes}}</textarea>
                    </label>
                    <label class="mt-6 block" for="bibliografia">Bibliografia
                        <textarea  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="bibliografia" id="bibliografia" cols="30" rows="10">{{$plan->sdd210ds_as_bibliografia}}</textarea>
                    </label>
                    @if(!isset($estado) )
                        @if($plan->sdd210ds_estado == 'p')
                        <p>Este archivo no se puede actualizar</p>
                        @else
                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-6">
                            Cargar
                        </button>
                        @endif
                    @else
                        @if(isset($plan->sdd210ds_estado) && $plan->sdd210ds_estado == 'p')
                        <span></span>
                        @else
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-6">
                                @if($estado->sdd200d_estado == 'c ' || $estado->sdd200d_estado == 'rj' || $estado->sdd200d_estado == 'ff')
                                Subida definitiva
                                @elseif($estado->sdd200d_estado == 'a ')
                                Enviar para revision
                                @elseif($estado->sdd200d_estado == 'rs')
                                Enviar a jefe de departamento
                                @else
                                Cargar
                                @endif
                            </button>
                        @endif
                    @endif
                    </form>
                    <div id="editorjs"></div>
                    
                </div>
            </div>
        </div>

        
    </div>
    <script>

        $('.plan_formulario').ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });
        $('[data-option-button]').click(e=>{
            // where is the action coming from ang where is going to
            dataName = $(e.currentTarget).attr('data-option-button')
            console.log(dataName)
            // the name value of the element just created
            dataValue = $(`[data-option-input=${dataName}]`).val()
            $(`[data-option-input=${dataName}]`).val('')
            // an element with the title just asigned with a delete button
            option = document.createElement('input')
            option.type='text'
            option.value = dataValue
            option.name = dataName+'[]'
            option.readOnly = true

            
            // contenedor para la opcion creada
            container = document.createElement('div')
            container.className = 'option__element__container'
            container.setAttribute('data-option-container', dataValue)

            // boton de eliminar
            close_btn = document.createElement('div')
            close_btn.className = 'option__element__closebtn'
            close_btn.textContent = 'x'

            container.appendChild(option)
            container.appendChild(close_btn)

            // se agrega el documento
            $(`[data-option-container=${dataName}]`).append(container)


            numero = $(`.option__expanded__container`).length


            // se crea el area del area de texto
            option_expanded_container = document.createElement('div')
            option_expanded_title = document.createElement('p')
            option_expanded_textarea = document.createElement('textarea')
            option_expanded_orden = document.createElement('input')
            option_expanded_textarea.placeholder = 'Contenido del tema';
            option_expanded_title.textContent = dataValue
            option_expanded_title_input = document.createElement('input')
            option_expanded_title_input.value = dataValue;
            option_expanded_title_input.name = `temario[${numero}][nombre]`
            option_expanded_textarea.name = `temario[${numero}][contenido]`
            option_expanded_orden.name = `temario[${numero}][orden]`
            option_expanded_orden.value = numero
            


            option_expanded_container.appendChild(option_expanded_title)
            option_expanded_container.appendChild(option_expanded_title_input)
            option_expanded_container.appendChild(close_btn)
            option_expanded_container.appendChild(option_expanded_orden)
            option_expanded_container.appendChild(option_expanded_textarea)
            option_expanded_textarea.className = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full'
            option_expanded_textarea.rows = 5

            option_expanded_container.className = 'option__expanded__container'
            option_expanded_container.setAttribute(`data-option-parent`, dataValue)



            $(`[data-option-expand=${dataName}]`).append(option_expanded_container)


        })

        $('[data-option-controller]').on('click', '.option__element__closebtn', e => {
            console.log(e.currentTarget)
            deleteElement = $(e.currentTarget).parent().attr('data-option-container')
            console.log($(e.currentTarget).parent().attr('data-option-container'))

            $(`[data-option-parent="${deleteElement}"]`).remove()
            $(e.currentTarget).parent().remove()
        })
        $('.options-extend-container').on('click', '.option__element__closebtn', e => {
            deleteElement = $(e.currentTarget).parent().attr('data-option-parent')
            $(e.currentTarget).parent().remove()
            $(`[data-option-container="${deleteElement}"]`).remove()

            neworder = document.querySelectorAll('.option__expanded__container')
            console.log(neworder)
            neworder.forEach((ele,idx)=>{
                console.log(ele)
                console.log(idx)
                console.log(ele.querySelector('input[name$="[nombre]"]').setAttribute('name', `temario[${idx}][nombre]`))
                ele.querySelector('input[name$="[nombre]"]').setAttribute('name', `temario[${idx}][nombre]`)
                ele.querySelector('input[name$="[orden]"]').setAttribute('name', `temario[${idx}][orden]`)
                ele.querySelector('input[name$="[orden]"]').value = `${idx}`
                ele.querySelector('textarea[name$="[contenido]"]').setAttribute('name', `temario[${idx}][contenido]`)
            })
        })

    </script>

    
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/nested-list@latest"></script>

<script>
    data = {
"time": 1713461065267,
"blocks": [
    {
        "id": "DNXoJm-e3h",
        "type": "paragraph",
        "data": {
            "text": "a,lsdqw"
        }
    },
    {
        "id": "M_qhzyVlFh",
        "type": "list",
        "data": {
            "style": "unordered",
            "items": [
                {
                    "content": "sadsada",
                    "items": []
                },
                {
                    "content": "sdewqeqw",
                    "items": []
                },
                {
                    "content": "eqwewqe",
                    "items": []
                }
            ]
        }
    }
],
"version": "2.29.1"
}
    il8n = {
            /**
 * @type {I18nDictionary}
 */
                messages:{
                ui:{
                    "blockTunes": {
                        "toggler": {
                            "Click to tune": "Click para posicionar",
                            "or drag to move": "o arrastra para mover"
                        },
                    },
                    "inlineToolbar": {
                        "converter": {
                            "Convert to": "Convertir a"
                        }
                    },
                    "toolbar": {
                        "toolbox": {
                            "Add": "Agregar"
                        }
                    }
                },
                toolNames: {
                    "Text": "Texto",
                    "Heading": "Titulo",
                    "List": "Lista",
                    "Warning": "Advertencia",
                    "Checklist": "Checklist",
                    "Quote": "Cita",
                    "Code": "Codigo",
                    "Delimiter": "Delimitador",
                    "Raw HTML": "HTML",
                    "Table": "Tabla",
                    "Link": "Link",
                    "Marker": "Marcador",
                    "Bold": "Negritas",
                    "Italic": "Italizado",
                    "InlineCode": "Codigo en linea",
                },
            },
            blockTunes: {
                "deleteTune": {
                "Delete": "Удалить"
                },
                "moveUp": {
                "Move up": "Переместить вверх"
                },
                "moveDown": {
                "Move down": "Переместить вниз"
                }
            },
            
        }
    tools = {
        // Add tools as needed
            header: {
                class: Header,
                inlineToolbar: true,
                config: {
                    placeholder: 'Enter a header',
                    levels: [2, 3, 4],
                    defaultLevel: 3
                }
            },
            list: {
                class: NestedList,
                inlineToolbar: true,
                config: {
                    defaultStyle: 'unordered'
                }
            },
        }

    console.log(@json($plan->sdd210ds_r_capacidades))
    const capacidades = new EditorJS({
        holder: 'capacidades-text',
        data: JSON.parse(@json($plan->sdd210ds_r_capacidades)),
        tools: tools,
        i18n: il8n
    });

    const habilidades = new EditorJS({
        holder: 'habilidades-text',
        data: JSON.parse(@json($plan->sdd210ds_r_habilidades)),
        tools: tools,
        i18n: il8n
    });

    const capacidadestematica = new EditorJS({
        holder: 'capacidades_profesionales_tematica-text',
        data: JSON.parse(@json($plan->sdd210ds_r_capacidades_profesionales)),
        tools: tools,
        i18n: il8n
    });

    const valoresactitudes = new EditorJS({
        holder: 'valores_actitudes-text',
        data: JSON.parse(@json($plan->sdd210ds_a_valores_actitudes)),
        tools: tools,
        i18n: il8n
    });

    const red_tematica = new EditorJS({
        holder: 'red_tematica-text',
        data:  JSON.parse(@json($plan->sdd210ds_r_red_tematica)),
        tools: tools,
        i18n: il8n
    });

    const estrategias_docentes = new EditorJS({
        holder: 'estrategias_docentes-text',
        data: JSON.parse(@json($plan->sdd210ds_r_capacidades)),
        tools: tools,
        i18n: il8n
    });

    const estrategias_aprendizaje = new EditorJS({
        holder: 'estrategias_aprendizaje-text',
        data: JSON.parse(@json($plan->sdd210ds_r_capacidades)),
        tools: tools,
        i18n: il8n
    });

    



    $('.plan_formulario').on('submit', (e)=>{
        // capacidades.save().then((outputData) => {
        // console.log('Article data: ', outputData);
        // $('textarea#capacidades').val(JSON.stringify(outputData))
        // }).catch((error) => {
        // console.log('Saving failed: ', error);
        // });
        const promises = [
            new Promise((resolve,reject)=>{
                capacidades.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#capacidades').val(JSON.stringify(outputData))
                    resolve(outputData)
                }).catch((error) => {
                    reject(error)
                    console.log('Saving failed: ', error);
                });
            }),
            new Promise((resolve,reject)=>{
                habilidades.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#habilidades').val(JSON.stringify(outputData))
                }).catch((error) => {
                    console.log('Saving failed: ', error);
                });
            }),
            new Promise((resolve,reject)=>{
                capacidadestematica.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#capacidades_profesionales_tematica').val(JSON.stringify(outputData))
                }).catch((error) => {
                    console.log('Saving failed: ', error);
                });
            }),
            new Promise((resolve,reject)=>{
                valoresactitudes.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#valores_actitudes').val(JSON.stringify(outputData))
                }).catch((error) => {
                    console.log('Saving failed: ', error);
                });
            }),
            new Promise((resolve,reject)=>{
                red_tematica.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#red_tematica').val(JSON.stringify(outputData))
                }).catch((error) => {
                    console.log('Saving failed: ', error);
                });
            }),
            new Promise((resolve,reject)=>{
                estrategias_docentes.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#estrategias_docentes').val(JSON.stringify(outputData))
                }).catch((error) => {
                    console.log('Saving failed: ', error);
                });
            }),
            new Promise((resolve,reject)=>{
                estrategias_aprendizaje.save().then((outputData) => {
                    console.log('Article data: ', outputData);
                    $('textarea#estrategias_aprendizaje').val(JSON.stringify(outputData))
                }).catch((error) => {
                    console.log('Saving failed: ', error);
                });
            }),
        ]
            
            Promise.allSettled(promises).then((result)=>{
                console.log("All promises have been resolved", result)
            }).catch((error)=>{
                console.log("At leat any one promise was rejected:", error)
            })

    })
</script>
</x-app-layout>