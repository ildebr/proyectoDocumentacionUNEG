<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Asignar edicion/creacion de plan de asignatura
                    </h2>

                    {{auth()->user()->cedula}}

                    @if ($error!='')
                        <p>{{$error}}</p>
                    @else
                        <p>Esta asignando las siguientes asignaturas</p>

                        <div class="mt-5 mb-5">
                            <p>{{$asignado[0]->sdd200d_nom_asign}}</p>
                        </div>

                        <form method="POST" action="">
                            @csrf
                            <input type="hidden" name="lapso" value="{{$lapso}}">
                            <input type="hidden" name="carrera" value="{{$carrera}}">
                            <input type="hidden" name="asignaturas[]" value="{{$asignatura}}">
    
    
    
                            <h3 class="mt-2 mb-1">Asignar a</h3>
                        
                            <select required name="user-plan" id="user-plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value=""></option>
                                @foreach ($users as $user)
                                    <option value="{{$user['cedula']}}">{{$user['name']}}</option>
                                @endforeach
                            </select>
    
                            <div>
   
                                <label for="tipo_asignacion" id="indirecta">
                                    <input type="hidden" name='tipo_asignacion' value="indirecta" required> <span>Indirecta</span>
                                </label>
                            </div>
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-6">Asignar</button>
                        </form>

                    @endif
                </div>
            </div>
        </div>
    </div>



</x-app-layout>