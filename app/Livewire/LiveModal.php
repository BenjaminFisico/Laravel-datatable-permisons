<?php

namespace App\Livewire;

use App\Models\User;
use App\Http\controllers\UserController;
use App\Http\Requests\RequestUser;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class LiveModal extends Component
{
    use WithFileUploads;
    public $showModal = 'hidden';
    public string $name = '';
    public string $email = '';
    public string $role = '';
    public array $roles;
    public string $action = '';
    public string $tittle = '';
    public string $submitMethod = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public $profile_photo_path = null;
    public User $user;
    private $userController;

    protected $listeners = [
        'showModal' => 'showModal',
        'showModalNewUser' => 'showModalNewUser',
    ];

    public function __construct(){
        $this->userController = (new UserController);
    }

    public function showModal(User $userToEdit){
        $this->user = $userToEdit;
        $this->roles = Role::pluck('name', 'name')->toArray();
        $this->name = $userToEdit->name;
        $this->email = $userToEdit->email;
        $this->role = $userToEdit->roles()->first()->name ?? '';
        $this->action = 'Actualizar';
        $this->tittle = 'Editar usuario';
        $this->submitMethod = 'updateUser';
        $this->showModal = '';
    }

    public function updateUser(){
        $requestUser = new RequestUser();
        $okValues = $this->validate($requestUser->rules($this->user), $requestUser->messages());
        $this->userController->updateUser($this->user, $okValues);
        $this->hiddenModal();
    }

    public function showModalNewUser(){
        $this->action = "Guardar";
        $this->tittle = 'Añadir usuario';
        $this->submitMethod = 'storeUser';
        $this->roles = Role::pluck('name', 'name')->toArray();
        $this->showModal = '';
    }

    public function hiddenModal(){
        $this->dispatch('reloadTable');
        $this->resetErrorBag();
        $this->reset();
    }

    public function storeUser(){
        $requestUser = new RequestUser();
        $okValues = $this->validate($requestUser->rules(null), $requestUser->messages());
        $this->userController->storeUser($okValues);
        $this->hiddenModal();
    }

    public function render()
    {
        return view('livewire.live-modal');
    }

}
