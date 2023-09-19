<div>
   <x-component-modal :showModal="$showModal" closeText="Cerrar">
      <div class="w-full">
         <h3 class="text-2xl text-center mt-3 text-gray-500">Permisos</h3>
         <hr>
         <div class="w-full mt-3 text-gray-500">
            @foreach($permissionsCheck as $key => $permission)
            <div class="flex flex-row mt-2">
               <div class="mr-2">
                  <span class="fa {{$permission['check'] ? 'fa-check' : ''}}"></span>
               </div>
               <div class="w-3/4">
                  {{$key}}
               </div>
               <div class="flex-1">
                  <input type="checkbox" wire:model="permissionsCheck.{{$key}}.check"
                        wire:click="addPermissionToModel('{{$key}}')"
                        class="bg-blue-100">
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </x-component-modal>
</div>
