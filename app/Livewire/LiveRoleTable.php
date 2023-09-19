<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Http\Controllers\RoleController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LiveRoleTable extends Component
{

    private $roleController;

    protected $listeners = [
        'reloadTable' => 'render'
    ];

    public function __construct(){
        $this->roleController = new RoleController();
    }

    public function render()
    {
        $roles = $this->roleController->getAllRolesWithUsersCount();
        
        $permissions = Permission::all();
        $permissions = $permissions->each(function($permission){
            $permission->countUsers = User::permission($permission->name)->count();
        });

        return view('livewire.live-role-table', compact('roles', 'permissions'));
    }

    public function showRoleModal($role){
        if($role){
            $this->dispatch('showEditModal', $role);
        } else {
            $this->dispatch('showNewRoleModal');
        }
    }

    public function addPermission(Role $role){
        $this->dispatch('showAddPermissionModal', $role, 'role');
    }

    public function deleteRole(Role $role){
        $this->roleController->deleteRole($role);
        $this->render();
    }

}
