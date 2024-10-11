<nav>
    <header class="nav-header">
        <div class="flex ml-3">
            <img src="{{asset('images/vin.jpg')}}" alt="vin" class='inline-block'>
            <p class="ml-3">MENU PRINCIPAL</p>
        </div>
    </header>
        <div class="flex ml-3 flex-col">
        @role('administrador')
        
            <p>Administrador</p>
            {{-- <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                {{ __('Admin') }}
            </x-nav-link> --}}
            <x-nav-link :href="route('admin.createuser')" :active="request()->routeIs('admin.createuser')">
                {{ __('Crear Usuario') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.listuser')" :active="request()->routeIs('admin.listuser')">
                {{ __('Listar Usuario') }}
            </x-nav-link>
            {{-- <x-nav-link :href="route('general.crearplan')" :active="request()->routeIs('general.crearplan')">
                {{ __('Crear Plan') }}
            </x-nav-link>
            <x-nav-link :href="route('general.cargarplan')" :active="request()->routeIs('general.cargarplan')">
                {{ __('Cargar/editar Plan') }}
            </x-nav-link> --}}
        
        @endrole

        @role('administrador')
            {{-- <p>Carreras</p>
            <x-nav-link :href="route('general.listarcarreras')" :active="request()->routeIs('general.listarcarreras')">
                {{ __('Listado de Carreras') }}
            </x-nav-link>
            <x-nav-link :href="route('general.listarasignaturas')" :active="request()->routeIs('general.listarasignaturas')">
                {{ __('Listado de Asignaturas') }}
            </x-nav-link> --}}
        @endrole
        <p>Planes</p>
        @role('administrador')
            
            <x-nav-link :href="route('general.listarplanes')" :active="request()->routeIs('general.listarplanes')">
                {{ __('Listado de Planes') }}
            </x-nav-link>
        @endrole
        <x-nav-link :href="route('plan.mostrarasignados')" :active="request()->routeIs('plan.mostrarasignados')">
            {{ __('Planes asignados') }}
        </x-nav-link>

        </div>
</nav>