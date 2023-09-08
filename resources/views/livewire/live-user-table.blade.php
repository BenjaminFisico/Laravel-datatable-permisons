<div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    <div class="flex text-gray-500">
      <select wire:model="perPage" wire:change="reloadTable()">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
      </select>

      <input type="text" class="form-input w-full ml-6" 
      wire:model="search"
      wire:keyDown="reloadTable()"
      placeholder="Ingrese el termino de busqueda..." />
      <button wire:click="clearFilters()" class="m-2">
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5 p-2">
          <span class="fa fa-eraser"></span>
        </div>
      </button>
    </div>

  <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
    <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          ID
          <button wire:click="sortable('id')">
            <span class="fa fa-{{ $sortableColumn == 'id' ? $icon : 'circle'}}" ><span>
          </button>
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          Name
          <button wire:click="sortable('name')">
            <span class="fa fa-{{ $sortableColumn == 'name' ? $icon : 'circle'}}" ><span>
          </button>
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">
          email
          <button wire:click="sortable('email')">
            <span class="fa fa-{{ $sortableColumn == 'email' ? $icon : 'circle'}}" ><span>
          </button>
        </th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Role</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
        @foreach($users as $user)
      <tr class="hover:bg-gray-50">
      <td class="px-6 py-4">{{ $user->id }}</td>
        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
          <div class="text-sm">
            <div class="font-medium text-gray-700">{{ $user->name }}</div>
          </div>
        </th>
        <td class="px-6 py-4">
          <span
            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600"
          >
            <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
            {{ $user->email }}
          </span>
        </td>
        <td class="px-6 py-4">User</td>
        <td class="px-6 py-4">
          <div class="flex justify-end gap-4">
            <a x-data="{ tooltip: 'Edite' }" href="#">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-6 w-6"
                x-tooltip="tooltip"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                />
              </svg>
            </a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    {{ $users->links() }}
  <div>
</div>
