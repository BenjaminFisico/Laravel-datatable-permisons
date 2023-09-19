<div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
  <div class="flex text-gray-500">
    <x-component-select-input inputName="perPage" label="" functionOnChange="reloadTable" :options="['5' => '5', '10' => '10', '15' => '15', '20' => '20']">
    </x-component-select-input>

    <input type="text" class="form-input w-full ml-6" wire:model="search" wire:keyDown="reloadTable()" placeholder="Ingrese el termino de busqueda..." />

    <x-component-select-input inputName="userRoleFilter" label="" functionOnChange="reloadTable" firstOption="Todos" :options="$roles">
    </x-component-select-input>

    <button wire:click="clearFilters()" class="m-2">
      <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5 p-2">
        <span class="fa fa-eraser"></span>
      </div>
    </button>
    @can('user create')
    <button type="button" class="mt-3 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-50 text-base font-medium text-gray-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" wire:click="showEditModal">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
      </svg>
    </button>
    @endcan
  </div>

  <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          ID
          <button wire:click="sortable('id')">
            <span class="fa fa-{{ $sortableColumn == 'id' ? $icon : 'circle'}}"><span>
          </button>
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          Imagen
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          Name
          <button wire:click="sortable('name')">
            <span class="fa fa-{{ $sortableColumn == 'name' ? $icon : 'circle'}}"><span>
          </button>
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          email
          <button wire:click="sortable('email')">
            <span class="fa fa-{{ $sortableColumn == 'email' ? $icon : 'circle'}}"><span>
          </button>
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          Role
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
        </th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
      @foreach($users as $user)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">{{ $user->id }}</td>
        <td class="px-6 py-4">
          <img class="w-10 h-10 rounded-full" src="{{asset('storage/'.$user->image_user) }}" alt="{{$user->name}}">
        </td>
        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
          <div class="text-sm">
            <div class="font-medium text-gray-700">{{ $user->name }}</div>
          </div>
        </th>
        <td class="px-6 py-4">
          <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
            <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
            {{ $user->email }}
          </span>
        </td>
        <td class="px-6 py-4">{{ $user->roles()->first()->name ?? 'N/A'}}</td>
        <td class="px-6 py-4">
          <div class="flex justify-end gap-4">
            @can('user update')
            <a x-data="{ tooltip: 'Edite' }" wire:click="showEditModal({{$user->id}})" class="cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
              </svg>
            </a>
            <a x-data="{ tooltip: 'Edite' }" wire:click="addPermission({{$user->id}})" class="cursor-pointer text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
            </svg>
            </a>
            @endcan
            @can('user delete')
            <div class="flex justify-end gap-4 text-red-600 hover:text-red-900 cursor-pointer">
              <a x-data="{ tooltip: 'Delete' }" onclick="borrarUsuario({{$user}})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
              </a>
            </div>
            @endcan
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    {{ $users->links() }}
    <div>
      @push('scripts')
      <script>
        function borrarUsuario(user) {
          console.log(user);
          if (confirm('¿Estas seguro de eliminar este usuario?')) {
            Livewire.dispatch('deleteUser', {
              user: user
            });
          }
        }

        Livewire.on('deleteIsOk', (user) => {
          if(user.userName != null){
            alert(`El usuario ${user.userName} se borro correctamente`);
          } else {
            alert(`Ha ocurrido un error inesperado`)
          }
        });
      </script>
      @endpush
    </div>