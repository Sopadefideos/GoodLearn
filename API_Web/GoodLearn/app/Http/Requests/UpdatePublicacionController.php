<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Usuario;

class UpdatePublicacionController extends FormRequest
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
        //$date = date('Y-m-d H:i:s');
        return [
            'titulo' => 'nullable|string',
            'url_img' => 'string|nullable',
            'fecha_creacion' => 'date|date_format:Y-m-d H:i:s|nullable',
            'fecha_modificacion' => ''
        ];
    }
}
