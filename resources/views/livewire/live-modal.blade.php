<div>
    <form wire:submit.prevent="{{$submitMethod}}">
        <x-component-modal :showModal="$showModal" :action="$action">
            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    {{$tittle}}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        <x-component-input placeholder="Ingrese un nombre" inputName="name" label="Nombre"></x-component-input>
                        <x-component-input placeholder="Ingrese un email" inputName="email" label="Email"></x-component-input>
                        <x-component-select-input inputName="role" label="Rol"
                        firstOption="selecione un rol"
                        :options="$roles">
                        </x-component-select-input>
                        <x-component-input placeholder="Ingrese una imagen" inputName="profile_photo_path" label="Imagen" type="file"></x-component-input>
                        @if($action == 'Guardar')
                            <x-component-input placeholder="Ingrese una clave" inputName="password" label="Contraseña" type="password"></x-component-input>
                            <x-component-input placeholder="Confirme la clave" inputName="passwordConfirm" label="Confimación de contraseña" type="password"></x-component-input>
                        @endif
                    </p>
                </div>
            </div>
        </x-component-modal>
    </form>
</div>
    