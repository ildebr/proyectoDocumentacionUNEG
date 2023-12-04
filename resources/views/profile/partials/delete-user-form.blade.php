<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Corrar cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Una vez borrada la cuenta, todos sus recursos y datos seran permanente eliminados. Antes de eliminar tu cuenta, por favor descarga cualquier informacion que tu quieras mantener.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Borrar cuenta') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('¿Seguro de querer eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Cuando tu cuenta haya sido eliminada, todos sus recursos y datos seran permanentes borrados. Por favor ingresa tu contraseña para confirmar que tu quieres eliminar tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Borrar cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
