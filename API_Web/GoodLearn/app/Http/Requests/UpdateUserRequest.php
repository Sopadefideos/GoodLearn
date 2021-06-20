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
        
        return [
            'email' => 'email|string|max:50|unique:usuario|nullable',
            'password' => 'string|min:8|nullable',
            'name' => 'string|max:50|nullable',
            'telefono' => 'string|max:15|nullable',
            'direccion' => 'string|max:100|nullable',
            'rol' => 'int|nullable|exists:rol,id',
        ];
    }
}
