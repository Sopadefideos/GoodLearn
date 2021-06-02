<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rol = $this->whenLoaded('rol');

        return [
            'id' => $this->id,
            'rol' => new CompanyResource($rol),
        ];
    }
}
