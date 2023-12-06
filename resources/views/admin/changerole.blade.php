{{-- {{$user}} --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cambiar Rol o Permisos de Usuario') }}
        </h2>
    </x-slot>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <table class="table-auto w-full p-4">
            <thead>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol(es)</th>
                <th>Permiso(s)</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{$user['name']}}</td>
                    <td>{{$user['email']}}</td>
                    <td>
                        @if($user->roles)
                        @foreach($user->roles as $role)
                        {{$role['name']}}
                        @endforeach
                        @endif
                    </td>
                </tr>
                
            </tbody>
        </table>

        <form method="POST" action="{{ route('admin.changeuserroleorpermission', ['id' => $user['id']]) }}">
            <!-- Rol -->
            @csrf
            <input type="hidden" name="form-name" value="rol" />
            <div class="mt-4">
                <x-input-label for="rol" :value="__('Rol')" />
                <select name="rol" class="block mt-1 w-full">
                    @foreach ($roles as $rol)
                        <option>{{$rol['name']}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('rol')" class="mt-2" />
            </div>

            <input type="submit" name="accion" value="Agregar" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <input type="submit" name="accion" value="Eliminar" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        </form>

        <form method="POST" action="{{ route('admin.changeuserroleorpermission', ['id' => $user['id']]) }}">
            <!-- Rol -->
            @csrf
            <input type="hidden" name="form-name" value="permission" />
            <div class="mt-4">
                <x-input-label for="permission" :value="__('Permission')" />
                <select name="permission" class="block mt-1 w-full">
                    @foreach ($permissions as $permission)
                        <option>{{$permission['name']}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('permission')" class="mt-2" />
            </div>
            <input type="submit" name="accion" value="Agregar" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <input type="submit" name="accion" value="Eliminar" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        </form>
    </div>
    
</x-app-layout>