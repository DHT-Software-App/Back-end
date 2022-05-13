<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbilityResource extends JsonResource
{

    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data" => [
                "type" => "abilities",
                "id" => (string) $this->id,
                "attributes" => $this->only('name','title','created_at','updated_at')
            ]
            
        ];
    }
}
