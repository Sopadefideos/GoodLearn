<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAsistenciaRequest extends FormRequest
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
            'asignatura_id' => 'nullable|exists:Asignaturas,id',
            'usuario_id' => 'nullable|exists:Usuario,id',
            'fecha_falta' => 'nullable',
            'fecha_creacion' => '',
            'fecha_modificacion' => ''
        ];
    }
}
