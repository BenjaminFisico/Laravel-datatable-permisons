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
    public $icon = 'circle';

    protected $queryString = [
        'search',
        'perPage',
        'sortableColumn' => ['as' => 'column'],
        'sortableOrder' => ['as' => 'order']
    ];

    public function render(){
        return view('livewire.live-user-table', [
            'users' => $this->getDbUserData(),
        ]);
    }

    private function getDbUserData(){
        $users = User::where('name', 'like', "{$this->search}%")
        ->orWhere('email', 'like', "{$this->search}%");

        if($this->sortableOrder && $this->sortableColumn){
            $users = $users->orderBy($this->sortableColumn, $this->sortableOrder);
        }

        $users = $users->paginate($this->perPage);

        return $users;
    }

    public function mount(){
        $this->icon = $this->setIconDirection($this->sortableOrder);
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

    private function setIconDirection($sort){
        if(!$sort){
            return 'circle';
        }

        return $sort == 'asc' ? 'arrow-circle-up' : 'arrow-circle-down';
    }

    public function clearFilters(){
        $this->search = '';
        $this->sortableColumn = null;
        $this->sortableOrder = null;
        $this->perPage = 5;
        $this->reloadTable();
    }

    public function reloadTable(){
        $this->resetPage();
    }
}
