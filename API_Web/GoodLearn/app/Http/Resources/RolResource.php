<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this->resource->whenLoaded('users'));
//        dump($this->resource->whenLoaded('users'));

        return [
            'id' => $this->id,
            'usuarios' => UsusarioResource::collection($this->whenLoaded('usuarios')),
        ];


    }
}
