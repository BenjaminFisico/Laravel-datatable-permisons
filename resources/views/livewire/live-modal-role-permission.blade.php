<div>
    <form wire:submit.prevent="{{$submitMethod}}">
        <x-component-modal :showModal="$showModal" :action="$action">
            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    {{$tittle}}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        <x-component-input placeholder="Ingrese un nombre" inputName="name" label="Rol"></x-component-input>
                    </p>
                </div>
            </div>
        </x-component-modal>
    </form>
</div>