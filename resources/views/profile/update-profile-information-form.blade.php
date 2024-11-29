<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Información de Perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualiza la información de perfil de tu cuenta, exceptuando el CI, Nombre y Correo Electrónico.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="!photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name (Read-Only) -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nombre y Apellido') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full bg-gray-200" wire:model="state.name" readonly />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- CI (Read-Only) -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="ci_police" value="{{ __('Cédula de Identidad') }}" />
            <x-input id="ci_police" type="text" class="mt-1 block w-full bg-gray-200" wire:model="state.ci_police" readonly />
            <x-input-error for="ci_police" class="mt-2" />
        </div>

        <!-- Email (Read-Only) -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Correo Electrónico') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full bg-gray-200" wire:model="state.email" readonly />
            <x-input-error for="email" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="phone" value="{{ __('Celular') }}" />
            <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="state.phone" autocomplete="tel" />
            <x-input-error for="phone" class="mt-2" />
        </div>

        <!-- Grade -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="grade" value="{{ __('Grado') }}" />
            <x-input id="grade" type="text" class="mt-1 block w-full" wire:model="state.grade" autocomplete="grade" />
            <x-input-error for="grade" class="mt-2" />
        </div>

        <!-- Escalafón -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="escalafon" value="{{ __('Escalafón') }}" />
            <x-input id="escalafon" type="text" class="mt-1 block w-full" wire:model="state.escalafon" autocomplete="escalafon" />
            <x-input-error for="escalafon" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
