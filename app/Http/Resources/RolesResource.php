<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "types"=>"Roles",
            'attribute' => [
                'id' => $this->id,
                'name' => $this->name,
            ],
            "relationships"=>[
                "Permission"=>[ 
                    "data"=>[
                      "type"=> "Permission",
                      "links" => env('APP_URL')."/api/roles/permission/".$this->id
                    ]
                ]
            ]
        ];
    }
}