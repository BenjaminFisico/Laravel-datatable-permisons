<?php

namespace App\Livewire;

use App\Http\Requests\RequestUpdateUser;
use Livewire\Component;
use App\Models\User;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class LiveModal extends Component
{
    use WithFileUploads;
    public $showModal = 'hidden';
    public string $name = '';
    public string $email = '';
    public string $role = '';
    public string $action = '';
    public string $tittle = '';
    public string $submitMethod = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public $profile_photo_path = null;
    public User $user;

    protected $listeners = [
        'showModal' => 'showModal',
        'showModalNewUser' => 'showModalNewUser',
    ];


    public function showModal(User $userToEdit){
        $this->user = $userToEdit;
        $this->name = $userToEdit->name;
        $this->email = $userToEdit->email;
        $this->role = $userToEdit->role;
        $this->action = 'Actualizar';
        $this->tittle = 'Editar usuario';
        $this->submitMethod = 'updateUser';
        $this->showModal = '';
    }

    public function showModalNewUser(){
        $this->action = "Guardar";
        $this->tittle = 'Añadir usuario';
        $this->submitMethod = 'storeUser';
        $this->showModal = '';
    }

    public function hiddenModal(){
        $this->resetErrorBag();
        $this->reset();
    }

    public function updateUser(){
        $requestUser = new RequestUpdateUser();
        $okValues = $this->validate($requestUser->rules($this->user), $requestUser->messages());

        $this->removeActualImage($this->user->profile_photo_path);
        if($okValues['profile_photo_path']){
            $profilePhoto = ['profile_photo_path' => $this->loadImage($okValues['profile_photo_path'])];
            $okValues = array_merge($okValues, $profilePhoto);
        }

        $this->user->update($okValues);
        $this->dispatch('reloadTable');
        $this->hiddenModal();
    }

    private function removeActualImage($path){
        if (!$path){
            return;
        }

        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
        }
    }

    public function storeUser(){
        $requestUser = new RequestUpdateUser();
        $okValues = $this->validate($requestUser->rules(null), $requestUser->messages());

        $user = new User;
        $user->fill($okValues);
        $user->password = bcrypt($okValues['password']);
        if($okValues['profile_photo_path']){
            $user->profile_photo_path = $this->loadImage($okValues['profile_photo_path']);
        }
        
        $user->save();
        $this->dispatch('reloadTable');
        $this->hiddenModal();
    }

    private function loadImage(TemporaryUploadedFile $image){
        $extencion = $image->getClientOriginalExtension();
        $newName = time().'.'.$extencion;

        $location = Storage::disk('public')->put('img/',$image);
        return $location;
    }

    public function render()
    {
        return view('livewire.live-modal');
    }

}
