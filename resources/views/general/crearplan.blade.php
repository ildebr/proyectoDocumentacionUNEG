<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Crear plan
                    </h2>

                    <p></p>

                    <form>
                        <label for="nombre_plan">
                            Nombre del plan
                            <input type="text" name="nombre_plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </label>

                        <p>comentario: se va a crear con un estado de edicion, yendo a la vista de detalle del plan se podra ver</p>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>