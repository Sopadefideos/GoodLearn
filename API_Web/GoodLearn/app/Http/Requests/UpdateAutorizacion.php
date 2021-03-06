<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAutorizacion extends FormRequest
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
            'asignatura_id' => 'nullable|exists:asignaturas,id',
            'usuario_id' => 'nullable|exists:usuario,id',
            'url_autorizacion' => 'nullable|string',
            'estado' => ''
        ];
    }
}
