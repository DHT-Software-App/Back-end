<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "types"=>"Users",
            'attribute' => [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'street' => $this->street,
                'zip' => $this->zip,
            ],
            "relationships"=>[
                "city"=>[ 
                    "data"=>[
                      "type"=> "city",
                      "id"=> $this->id_city,
                      "links" => env('APP_URL')."/api/cities/{id}"
                    ]
                ],
                "state"=>[ 
                    "data"=>[
                      "type"=> "state",
                      "id"=>  $this->id_state,
                      "links" => env('APP_URL')."/api/states/{id}"
                    ]
                ],
                "Rol"=>[ 
                    "data"=>[
                      "type"=> "rol ",
                      "id"=>  $this->role,
                      "links" => env('APP_URL')."/api/roles/{id}"
                    ]
                ],
            ]
        ];
    }
}