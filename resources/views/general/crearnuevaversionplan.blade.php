<x-app-layout>
    <div class="py-12" id="listarplanes">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        ¿Estás seguro/a de crear una nueva version de plan de la asignatura {{$asignatura->sdd090d_nom_asign}} para el lapso de vigencia {{request()->route('lapso')}}?
                    </h2>

                    <p class="mb-2">Presione el boton debajo de estar de acuerdo</p>
                    <p class="mb-2">Una vez presionado no hay vuelta atras</p>

                    <form method="POST" action="{{ route('general.crearnuevaversionplan', ['lapso' => request()->route('lapso'), 'carrera'=> request()->route('carrera'), 'asignatura'=>request()->route('asignatura')]) }}">
                        @csrf
                        <button class="options-cta inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-2">Crear Nueva Version de Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>