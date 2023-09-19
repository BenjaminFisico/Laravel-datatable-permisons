<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRole extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|unique:roles,name',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'El nombre del rol es requerido',
            'name.unique' => 'Ya existe un rol con ese nombre',
        ];
    }
}
