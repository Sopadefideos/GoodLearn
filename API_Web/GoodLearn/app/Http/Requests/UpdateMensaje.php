<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMensaje extends FormRequest
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
            'emisor_id' => 'nullable|exists:Usuario,id',
            'receptor_id' => 'nullable|exists:Usuario,id',
            'texto' => '',
            'fecha_creacion' => '',
            'fecha_modificacion' => ''
        ];
    }
}
