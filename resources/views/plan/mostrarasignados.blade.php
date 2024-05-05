<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Planes asignados
                    </h2>

                    <p class="mt-4 mt-8">Los siguientes son una lista de planes que tienes asignado</p>

                    {{auth()->user()->cedula}}

                    @if($status!='')
                    <h3>{{$status}}</h3>
                    @endif
                    {{$status}}

                    @if (count($asignados) >= 0)
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <th>Nombre asignatura</th>
                            <th>Carrera</th>
                            <th>Lapso</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </thead>
                        <tbody>
                        @foreach ($asignados as $asignado)
                            <tr>
                                <td>{{$asignado->sdd200d_nom_asign}}</td>
                                <td>{{$asignado->sdd200d_cod_carr}}</td>
                                <td>{{$asignado->sdd200d_lapso_vigencia}}</td>
                                <td>
                                    @if($asignado->sdd200d_estado == 'a ')
                                    <span>Asignado</span>
                                    @else
                                    <span>Sin asignar</span>
                                    @endif
                                </td>                                
                                <td>
                                    <a href="{{route('general.plancrear', ['lapso'=>$asignado->sdd200d_lapso_vigencia, 'carrera' => $asignado->sdd200d_cod_carr, 'asignatura'=> $asignado->sdd200d_cod_asign])}}">Revisar</a> 
                                    @if(auth()->user()->cedula == $asignado->sdd200d_superior_asignado)
                                    <a href="{{route('general.asignarasignaturadirecta', ['lapso'=>$asignado->sdd200d_lapso_vigencia, 'carrera' => $asignado->sdd200d_cod_carr, 'asignatura'=> $asignado->sdd200d_cod_asign])}}">
                                        Reasignar
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No tiene ninguna asignacion todavia</p>                    
                    @endif
                </div>
            </div>
        </div>
    </div>


    
</x-app-layout>