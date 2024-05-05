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
                        Carga de plan sinoptico y analitico
                    </h2>
                
                    <h3 class="mt-2 mb-2"><strong>Informacion General</strong></h3>

                    <div class="form-grid grid grid-cols-3 gap-4 mb-4" style="">
                        <div>
                            <label for="codigo">Codigo </label>
                            <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" type="text" name="codigo">
                        </div>
                        <div>
                            <label for="uc">Unidad de credito</label>
                            <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" type="text" name="uc">
                        </div>
                        <div>
                            <label for="had">HAD</label>
                            <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" type="text" name="had">
                        </div>
                        <div>
                            <label for="cf">Componente de formacion</label>
                            <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="cf" id="cf">
                                <option value=""></option>
                                <option value="g">General</option>
                            </select>
                        </div>
                        <div>
                            <label for="caracter">Caracter</label>
                            <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="caracter" id="caracter">
                                <option value=""></option>
                                <option value="g">Obligatorio</option>
                                <option value="e">Electiva</option>
                            </select>
                        </div>
                    </div>

                    <label class="mt-6" for="comp_genericas">Competencias genericas
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_genericas" id="comp_genericas" cols="30" rows="10"></textarea>
                    </label>

                    

                    <h3 class="mb-4 mt-6 font-semibold text-xl text-gray-700 leading-tight">Carga de informacion de programa analitico</h3>
                    <label for="comp_form">Componente de formacion
                        <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_form" id="comp_form">
                            <option value=""></option>
                            <option value="g">General</option>
                            <option value="b">Profesional basica</option>
                            <option value="e">Profesional especializada</option>
                            <option value="p">Practica profesional</option>
                            <option value="s">Pasantia</option>
                        </select>
                    </label>
                    <label class="mt-6 block" for="comp_genericas_analiticas">competencias genericas
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_genericas_analiticas" id="comp_genericas_analiticas" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="comp_profesionales_analiticas">Competencias profesionales
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_profesionales_analiticas" id="comp_profesionales_analiticas" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="comp_uc">Competencias de la unidad curricular
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_uc" id="comp_uc" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="val_act">Valores y actitudes
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="val_act" id="val_act" cols="30" rows="10"></textarea>
                    </label>
                    
                    <label class="mt-6 block" for="temario">Temario
                        <div class="options-controller" data-option-controller='temario'>
                            <div class="options-container" data-option-container='temario'>
    
                            </div>
    
                            <input type="text" class="options-input border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" data-option-input="temario" placeholder="Ingresa un tema">
                            <button class="options-cta inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-2" data-option-button="temario">Añadir tema</button>
                        </div>
                        
                    </label>
                    <label class="mt-6 block" for="cont_tema_detalle">Contenido detallado por tema
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="cont_tema_detalle" id="cont_tema_detalle" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="est_didacticas">Estrategias didacticas
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="est_didacticas" id="est_didacticas" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="est_docentes">Estrategias docentes
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="est_docentes" id="est_docentes" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="est_aprendizajes">Estrategias de aprendizajes
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="est_aprendizajes" id="est_aprendizajes" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="ref_bibli">Referencias bibliograficas
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="ref_bibli" id="ref_bibli" cols="30" rows="10"></textarea>
                    </label>


                    <h3 class="mb-4 mt-6 font-semibold text-xl text-gray-700 leading-tight">Carga de informacion de programa sinoptico</h3>
                    <label class="mt-6 block" for="comp_profesionales">Competencias profesionales basicas de un ingeniero uneg
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_profesionales" id="comp_profesionales" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="comp_profesionales_esp">Competencias profesionales especificas de un UNEG
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="comp_profesionales" id="comp_profesionales" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="sinopsis_de_tema">Sinopsis de contenido del Tema

                        <div class="options-extend-container" data-option-expand='temario'>

                        </div>

                    </label>
                    <label class="mt-6 block" for="est_didacticas">Estrategias didacticas
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="est_didacticas" id="est_didacticas" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="est_evaluacion">Estrategias de evaluacion
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="est_evaluacion" id="est_evaluacion" cols="30" rows="10"></textarea>
                    </label>
                    <label class="mt-6 block" for="bibl_principal">Bibliografia principal
                        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full" name="bibl_principal" id="bibl_principal" cols="30" rows="10"></textarea>
                    </label>

                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-6">Enviar para revision</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('[data-option-button]').click(e=>{
            dataName = $(e.currentTarget).attr('data-option-button')
            console.log(dataName)
            dataValue = $(`[data-option-input=${dataName}]`).val()
            $(`[data-option-input=${dataName}]`).val('')
            option = document.createElement('input')
            option.type='text'
            option.value = dataValue
            option.name = dataName
            option.readOnly = true

            container = document.createElement('div')
            container.className = 'option__element__container'
            container.setAttribute('data-option-container', dataValue)

            close_btn = document.createElement('div')
            close_btn.className = 'option__element__closebtn'
            close_btn.textContent = 'x'

            container.appendChild(option)
            container.appendChild(close_btn)



            
            

            $(`[data-option-container=${dataName}]`).append(container)

            option_expanded_container = document.createElement('div')
            option_expanded_title = document.createElement('p')
            option_expanded_textarea = document.createElement('textarea')
            option_expanded_title.textContent = dataValue
            option_expanded_container.appendChild(option_expanded_title)
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

    </script>
</x-app-layout>