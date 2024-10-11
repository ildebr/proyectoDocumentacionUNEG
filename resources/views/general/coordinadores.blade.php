<style>
    label{
        font-weight: 600;
    }
</style>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Editar Coordinadores
                    </h2>
                    {{isset($coordinadores->sdd900ds_coordinador_de_curriculo) && $coordinadores->sdd900ds_coordinador_de_curriculo}}
                    <p>El texto presente aqui sera el agregado a todos los planes creados.</p>

                    <form class="mt-4">
                        <label for="nombre_plan">
                            Coordinador(a) de Programa o Proyecto
                            <input type="text" name="nombre_plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </label>

                        <label for="nombre_plan" class="mt-4">
                            Coordinador(a) de Curriculo
                            <input type="text" name="nombre_plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </label>

                        @foreach ($carreras as $carrera)
                        <label for="nombre_plan" class="mt-4">
                            Coordinador(a) de {{$carrera->sdd080d_nom_carr}}
                            <input type="text" name="nombre_plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </label>
                        @endforeach

                        <button>Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>