<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RequestUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules($user): array
    {
        $roles = $this->getAllRolesString();
        $rules = [
            'name'=>'required|min:3|max:30',
            'email'=>['required','email', Rule::unique('users','email')->ignore($user)],
            'role' => "required|in:{$roles}",
            'profile_photo_path' => 'nullable|image'
        ];

        if(!$user){
            $passwordValidation = [
                'password' => 'required|min:6',
                'passwordConfirm' => 'required|same:password'
            ];
            $rules = array_merge($rules, $passwordValidation);
        }

        return $rules;
    }

    private function getAllRolesString(): string{
        $roles = Role::pluck('name');
        return $roles->join(',');
    }

    public function messages(): array{
        return [
            'name.required'=>'El campo nombre es obligatorio',
            'name.min'=>'El campo nombre debe tener al menos 3 caracteres',
            'name.max'=>'El campo nombre debe tener menos de 30 caracteres',
            'email.required'=>'El campo email es obligatorio',
            'email.email'=>'El campo email debe ser un email válido',
            'email.unique'=>'Ese email ya esta registrado en el sistema',
            'role.required'=>'Seleccione algún rol',
            'role.in'=>'Seleccione un rol válido',
            'password.required'=>'El campo contraseña es obligatorio',
            'password.min'=>'El campo contraseña debe tener al menos 6 caracteres',
            'passwordConfirm.required'=>'El campo confirmar contraseña es obligatorio',
            'passwordConfirm.same'=>'Las contraseñas no coinciden'
        ];
    }
}
