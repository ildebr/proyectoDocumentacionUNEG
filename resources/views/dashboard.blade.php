<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    
            <section class="seccion-aterrizaje">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>{{ __("Bienvenido/a!") }}</h1>
                    </div>
                    <div class="p-6 text-gray-900">
                        <p>Sístema de administración de planes</p>
                    </div>
            </section>
            
    </div>
</x-app-layout>
