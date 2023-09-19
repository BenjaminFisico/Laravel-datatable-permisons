<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RequestRole;
use App\Http\Controllers\RoleController;

class LiveModalRolePermission extends Component
{

    public string $showModal = 'hidden';
    public string $action = '';
    public string $tittle = '';
    public string $submitMethod = '';
    public Role $role;
    public $name;
    private $roleController;

    protected $listeners = [
        'showEditModal' => 'showEditModal',
        'showNewRoleModal' => 'showNewRoleModal',
    ];

    public function __construct(){
        $this->roleController = new RoleController();
    }

    public function render()
    {
        return view('livewire.live-modal-role-permission');
    }

    public function showEditModal(Role $role){
        $this->role = $role;
        $this->name = $role->name;
        $this->tittle = 'Editar rol';
        $this->action = 'Actualizar';
        $this->submitMethod = 'updateRole';
        $this->showModal = '';
    }

    public function showNewRoleModal(){
        $this->tittle = 'Crear rol';
        $this->action = 'Guardar';
        $this->submitMethod = 'storeRole';
        $this->showModal = '';
    }

    public function hiddenModal(){
        $this->dispatch('reloadTable');
        $this->reset();
    }

    public function updateRole(){
        $request = new RequestRole();
        $okValues = $this->validate($request->rules(), $request->messages());

        $this->roleController->updateRole($this->role, $okValues);
        $this->hiddenModal();
    }

    public function storeRole(){
        $request = new RequestRole();
        $okValues = $this->validate($request->rules(), $request->messages());

        $this->roleController->storeRole($okValues);
        $this->hiddenModal();
    }
}
