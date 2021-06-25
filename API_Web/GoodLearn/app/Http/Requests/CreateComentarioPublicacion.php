<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateComentarioPublicacion extends FormRequest
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
            'publicacion_id' => 'required|exists:publicacions,id',
            'usuario_id' => 'required|exists:usuario,id',
            'comentario' => 'required|string',
            'fecha_creacion' => '',
            'fecha_modificacion' => ''
        ];
    }
}
