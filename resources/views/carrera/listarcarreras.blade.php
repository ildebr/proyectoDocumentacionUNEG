<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Asignar creacion de plan
                    </h2>

                    

                    <form>
                        <select name="user-plan" id="user-plan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            @foreach ($carreras as $carrera)
                                <option>{{$carrera['sdd080d_nom_carr']}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>