<?php

namespace App\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\User;

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

    public function render(){
        return view('livewire.live-user-table', [
            'users' => $this->getDbUserData(),
        ]);
    }

    private function getDbUserData(){
        $users = User::search($this->search)
            ->byRole($this->userRoleFilter);

        if($this->sortableOrder && $this->sortableColumn){
            $users = $users->orderBy($this->sortableColumn, $this->sortableOrder);
        }

        $users = $users->paginate($this->perPage);

        return $users;
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
            $this->dispatch('showModal', $user);
        } else {
            $this->dispatch('showModalNewUser');
        }
    }

    public function deleteUser(User $user){
        $userName = $user->name;
        $user->delete();

        $this->dispatch('deleteIsOk', userName: $userName);
    }

    public function clearFilters(){
        $this->reset();
    }

    public function reloadTable(){
        $this->resetPage();
    }
}
