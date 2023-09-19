<?php

namespace App\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\controllers\UserController;

class LiveUserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortableColumn = null;
    public $sortableOrder = null;
    public $userRoleFilter = '';
    public $icon = 'circle';
    public $showModal = 'hidden';
    private $userController;
    // url get params
    protected $queryString = [
        'search',
        'perPage',
        'sortableColumn' => ['as' => 'column'],
        'sortableOrder' => ['as' => 'order']
    ];

    protected $listeners = [
        'reloadTable' => 'reloadTable',
        'deleteUser' => 'deleteUser'
    ];

    public function __construct(){
        $this->userController = (new UserController);
    }

    public function render(){
        return view('livewire.live-user-table', [
            'users' => $this->getDbUserData(),
            'roles' => $this->getAllRoles(),
        ]);
    }

    private function getDbUserData(){
        $users = User::search($this->search)
            ->when($this->userRoleFilter != '', function($query){
               return $query->role($this->userRoleFilter);
            });

        if($this->sortableOrder && $this->sortableColumn){
            $users = $users->orderBy($this->sortableColumn, $this->sortableOrder);
        }

        $users = $users->paginate($this->perPage);

        return $users;
    }

    private function getAllRoles(){
        $allRoles = Role::pluck('name', 'name')->toArray();
        return $allRoles;
    }

    public function sortable($column){
        // Verifico si el usuario cambio de columna para evitar error en el primer ordenamiento
        if($column != $this->sortableColumn){
            $this->sortableOrder = null;
        }
        $this->sortableColumn = $column;
        $this->changeSortableOrder();
        $this->icon = $this->setIconDirection($this->sortableOrder);
    }

    private function changeSortableOrder(){
        switch($this->sortableOrder){
            case 'asc':
                $this->sortableOrder = 'desc';
                break;
            case 'desc':
                $this->sortableOrder = null;
                $this->sortableColumn = null;
                break;
            case null:
                $this->sortableOrder = 'asc';
                break;
        }
    }

    public function mount(){
        $this->icon = $this->setIconDirection($this->sortableOrder);
    }

    private function setIconDirection($sort){
        if(!$sort){
            return 'circle';
        }

        return $sort == 'asc' ? 'arrow-circle-up' : 'arrow-circle-down';
    }

    public function showEditModal(User $user){
        if($user->name != null){
            $this->userController->checkUserHasPermission('user update');
            $this->dispatch('showModal', $user);
        } else {
            (new UserController)->checkUserHasPermission('user create');
            $this->dispatch('showModalNewUser');
        }
    }

    public function deleteUser(User $user){
        if ($this->userController->deleteUser($user)){
            $userName = $user->name;
            $this->dispatch('deleteIsOk', userName: $userName);
            $this->reloadTable();
        } else {
            // Al no pasar 'userName' el front muestra mensaje de error
            $this->dispatch('deleteIsOk');
        }
    }

    public function clearFilters(){
        $this->reset();
    }

    public function reloadTable(){
        $this->resetPage();
    }

    public function addPermission(User $user){
        $this->dispatch('showAddPermissionModal', $user, 'user');
    }
}
