<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{Usuario, Publicacion};

class CreatePublicacionController extends FormRequest
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
            'titulo' => 'required|string',
            'url_img' => 'string|required',
        ];
    }
}
