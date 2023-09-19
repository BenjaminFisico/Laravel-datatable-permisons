<div>
    @can('role create')
    <button class="m-10 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-50 text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                    wire:click="showRoleModal(null)">Crear rol</button>
    @endcan
    <div class="flex flex-row">
        <div class="flex-1">
            <x-table tittle="Roles">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    ID</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Name</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Usos</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach($roles as $role)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{$role->id}}</td>
                            <td class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700">{{$role->name}}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{$role->countUsers}}</td>
                            <td class="">
                                @can('role update')
                                <span
                                    class="inline-flex cursor-pointer items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600"
                                    wire:click="showRoleModal({{$role->id}})">
                                    Editar
                                </span>
                                <span
                                    class="inline-flex cursor-pointer items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-purple-100"
                                    wire:click="addPermission({{$role->id}})">
                                    Permisos
                                </span>
                                @endcan
                                @if(!$role->countUsers)
                                    @can('role delete')
                                    <span
                                        wire:click="deleteRole({{$role->id}})"
                                        class="inline-flex cursor-pointer items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-red-600">
                                        Borrar
                                    </span>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
        <div class="flex-1 ml-3">
            <x-table tittle="Permisos">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    ID</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                    Name</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Usos</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach($permissions as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{$permission->id}}</td>
                        <td class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                            <div class="text-sm">
                                <div class="font-medium text-gray-700">{{$permission->name}}</div>
                            </div>
                        </td>
                        <td class="">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold">
                                {{$permission->countUsers}}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
    </div>
</div>


