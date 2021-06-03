<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAsistenciaRequest extends FormRequest
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
            'asignatura_id' => 'required|exists:Asignaturas,id',
            'usuario_id' => 'required|exists:Usuario,id',
            'fecha_falta' => 'required',
            'fecha_creacion' => '',
            'fecha_modificacion' => ''
        ];
    }
}
