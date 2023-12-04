<nav>
    <header class="nav-header">
        <div class="flex ml-3">
            <img src="images/vin.jpg" alt="vin" class='inline-block'>
            <p class="ml-3">MENU PRINCIPAL</p>
        </div>
    </header>

        @role('administrador')
        <div class="flex ml-3 flex-col">
            <p>Administrador</p>
            <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                {{ __('Admin') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.createuser')" :active="request()->routeIs('admin.createuser')">
                {{ __('Crear Usuario') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.listuser')" :active="request()->routeIs('admin.listuser')">
                {{ __('Listar Usuario') }}
            </x-nav-link>
        </div>
        @endrole
    
</nav>