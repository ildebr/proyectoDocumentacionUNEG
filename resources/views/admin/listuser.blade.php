<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Usuarios') }}
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
                @foreach ($users as $user)
                    <tr>
                        <td><a class="text-blue-700" href="{{ route('admin.changeuserroleorpermission', ['id' => $user['id']]) }}/">{{$user['name']}}</a></td>
                        <td>{{$user['email']}}</td>
                        <td>
                            @if($user->roles)
                            @foreach($user->roles as $role)
                            {{$role['name']}}
                            @endforeach
                            @endif
                        </td>
                        <td>
                            @if($user->permissions)
                            @foreach($user->permissions as $permission)
                            {{$permission['name']}}
                            @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>

        
    </div>
    
</x-app-layout>