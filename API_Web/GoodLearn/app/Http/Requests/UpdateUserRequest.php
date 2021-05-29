<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Rol;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roles = Rol::all();
        $tam = sizeof($roles);
        return [
            'email' => 'email|string|max:50|unique:usuario|nullable',
            'contraseña' => 'string|min:8|nullable',
            'name' => 'string|max:50|nullable',
            'telefono' => 'string|max:15|nullable',
            'direccion' => 'string|max:100|nullable',
            'rol' => 'int|nullable|digits_between: 1,'.$tam,
        ];
    }
}
