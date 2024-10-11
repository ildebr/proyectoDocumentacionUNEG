<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                
                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- segundo nombre -->

                        <div class="mt-4">
                            <x-input-label for="segundo_nombre" :value="__('Segundo Nombre')" />
                            <x-text-input id="segundo_nombre" class="block mt-1 w-full" type="text" name="segundo_nombre" :value="old('segundo_nombre')" required autofocus autocomplete="segundo_nombre" />
                            <x-input-error :messages="$errors->get('segundo_nombre')" class="mt-2" />
                        </div>

                        <!-- primer apellido -->

                        <div class="mt-4">
                            <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
                            <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido" :value="old('primer_apellido')" required autofocus autocomplete="primer_apellido" />
                            <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
                        </div>

                        <!-- segundo apellido -->

                        <div class="mt-4">
                            <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
                            <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido" :value="old('segundo_apellido')" required autofocus autocomplete="segundo_apellido" />
                            <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-2" />
                        </div>

                        <!-- segundo apellido -->

                        <div class="mt-4">
                            <x-input-label for="cedula" :value="__('Cedula')" />
                            <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" required autofocus autocomplete="cedula" />
                            <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                        </div>

                        <!-- Rol -->
                        <div class="mt-4">
                            <x-input-label for="rol" :value="__('Rol')" />
                            <select name="rol" class="block mt-1 w-full">
                                @foreach ($roles as $rol)
                                    <option>{{$rol['name']}}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                
                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                
                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                
                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                
                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password" />
                
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                
                        <div class="flex items-center justify-end mt-4">
                            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a> --}}
                
                            <x-primary-button class="ms-4">
                                {{ __('Registrar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
