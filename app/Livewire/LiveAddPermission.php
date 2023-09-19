<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LiveAddPermission extends Component
{
    public $showModal = 'hidden';
    public $permissionsCheck = [];
    public $model;
    protected $listeners = [
        'showAddPermissionModal' => 'showModal'  
    ];

    public function render()
    {
        return view('livewire.live-add-permission');
    }

    public function showModal($model, string $modelType){
        if($modelType == 'role'){
            $this->model = Role::find($model['id']);
        } else {
            $this->model = User::find($model['id']);
        }

        $this->assingCheckPermissionsByModel();
        $this->showModal = '';
    }

    private function assingCheckPermissionsByModel(){
        $allPermissions = Permission::all();

        foreach($allPermissions as $permission){
            if($this->model->hasPermissionTo($permission)){
                $this->permissionsCheck[$permission->name]['check'] = true;
            } else {
                $this->permissionsCheck[$permission->name]['check'] = false;
            }
            $this->permissionsCheck[$permission->name]['id'] = $permission->id;
        }
    }

    public function hiddenModal(){
        $this->showModal = 'hidden';
    }

    public function addPermissionToModel($permission){
        if($this->model->hasPermissionTo($permission)){
            $this->model->revokePermissionTo($permission);
        }else {
            $this->model->givePermissionTo($permission);
        }
    }

}
