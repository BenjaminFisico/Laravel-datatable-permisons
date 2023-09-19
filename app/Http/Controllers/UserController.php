<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUser;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UserController extends Controller
{
    public function list(){
        return view('user.list');
    }

    public function deleteUser(User $user): bool{
        $this->checkUserHasPermission('user delete');
        return $user->delete();
    }

    public function updateUser(User $user, $changedValues): bool{
        $this->checkUserHasPermission('user update');
        
        $this->removeActualImage($user->profile_photo_path);
        if($changedValues['profile_photo_path']){
            $profilePhoto = ['profile_photo_path' => $this->loadImage($changedValues['profile_photo_path'])];
            $changedValues = array_merge($changedValues, $profilePhoto);
        }
        $user->syncRoles($changedValues['role']);

        return $user->update($changedValues);
    }

    private function removeActualImage($path){
        if (!$path){
            return;
        }

        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
        }
    }

    public function storeUser($userValues): bool{
        $this->checkUserHasPermission('user create');

        $user = new User;
        $user->fill($userValues);
        $user->password = bcrypt($userValues['password']);
        if($userValues['profile_photo_path']){
            $user->profile_photo_path = $this->loadImage($userValues['profile_photo_path']);
        }
        $user->assignRole($userValues['role']);
        
        return $user->save();
    }

    private function loadImage(TemporaryUploadedFile $image){
        $extencion = $image->getClientOriginalExtension();
        $newName = time().'.'.$extencion;

        $location = Storage::disk('public')->put('img/',$image);
        return $location;
    }
    
    public function checkUserHasPermission($permission){
        if (!auth()->user()->can($permission)){
            abort(403, 'Acceso denegado');
        }
    }


}
