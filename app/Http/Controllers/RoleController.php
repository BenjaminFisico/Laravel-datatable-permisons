<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    private $userController;

    public function __construct(){
        $this->userController = new UserController();
    }

    public function storeRole($values): bool{
        $response = Role::create(['name' => $values['name'], 'guard_name' => 'web']);
        if(!$response){
            return false;
        }
        return true;
    }

    public function updateRole(Role $role, $changedValues): bool{
        $this->userController->checkUserHasPermission('role update');
        return $role->update($changedValues);
    }
    
    public function getAllRolesNames(){
        return Role::all()->pluck('name')->toArray();
    }

    public function getAllRolesWithUsersCount(){
        $roles = Role::all();
        $roles = $roles->each(function($role){
            $role->countUsers = User::role($role->name)->count();
        });

        return $roles;
    }

    public function deleteRole(Role $role): bool{
        return $role->delete();
    }
    
}
