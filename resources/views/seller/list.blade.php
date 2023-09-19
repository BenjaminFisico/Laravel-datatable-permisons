<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendedores registrados en el sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex">
                    @can('seller create')
                        <button class="flex-1">Create</button>
                    @endcan
                    @can('seller update')
                    <button class="flex-1">Update</button>
                    @endcan
                    @can('seller delete')
                    <button class="flex-1">Delete</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @push('modals')
        <livewire:live-modal />
    @endpush
</x-app-layout>