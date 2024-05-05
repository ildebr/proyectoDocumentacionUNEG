<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Asignar edicion/creacion de plan de asignatura
                    </h2>

                    @if(isset($data['error']) && $data['error'] =='')

                    <p>Esta asignando las siguientes asignaturas</p>
                    @foreach ($data['seleccionadas'] as $sel)
                        {{$sel}}
                    @endforeach


                    <div class="mt-5 mb-5">
                        @foreach ($selresults as $asign)
                            <p>{{$asign->sdd090d_nom_asign}}</p>
                        @endforeach
                    </div>

                    <p>Nota: Al asignar coordinador le esta otorgando la capacidad de que este asigna la(s) asignatura(s) a otro profesor o lo complete el/ella mismo/a.</p>
                    <p>Al completar la carga de informacion asignado por un coordinador, este pasara al coordinador para ser aprobado y luego a la/el jefe de departamento.</p>


                    <form method="POST" action="{{route('general.asignarasignatura')}}">
                        @csrf
                        <input type="hidden" name="lapso" value="{{$data['lapso']}}">
                        <input type="hidden" name="carrera" value="{{$data['carrera']}}">

                        @foreach ($selresults as $asign)
                            <input type="hidden" name="asignaturas[]" value="{{$asign->sdd090d_cod_asign}}">
                        @endforeach


                        <h3 class="mt-2 mb-1">Asignar a</h3>
                    
                        <select required name="user-plan" id="user-plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value=""></option>
                            @foreach ($data['users'] as $user)
                                <option value="{{$user['cedula']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>

                        <div>
                            <h3 class="mt-2 mb-1">Seleccione si es asignacion directa o indirecta</h3>
                            <label for="tipo_asignacion" id="directa">
                                <input type="radio" name='tipo_asignacion' value="directa" required> <span>Directa</span>
                            </label>
                            <label for="tipo_asignacion" id="indirecta">
                                <input type="radio" name='tipo_asignacion' value="indirecta" required> <span>Indirecta</span>
                            </label>
                        </div>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-6">Asignar</button>
                    </form>

                    @else 

                    <h2 class="font-semibold text-xl text-red-800 leading-tight mt-5">{{$data['error']}}</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>



</x-app-layout>