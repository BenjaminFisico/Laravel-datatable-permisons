<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles y permisos del sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <livewire:live-role-table />
            </div>
        </div>
    </div>
    @push('modals')
        <livewire:live-add-permission/>
        <livewire:live-modal-role-permission/>
    @endpush
</x-app-layout>