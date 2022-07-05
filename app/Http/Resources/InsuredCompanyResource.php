<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InsuredCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
    public function toArray($request)
    {
        $this->contact = explode(",", $this->contact);
        $this->email = explode(",", $this->email);
        return [
            "types"=>"Clients",
            'attribute' => [
                'id' => $this->id,
                'company' => $this->company,
                'street' => $this->street,
                'zip' => $this->zip,
                'contact'=> $this->contact,
                'email'=> $this->email
            ],
            "relationships"=>[
                "city"=>[ 
                    "data"=>[
                      "type"=> "city",
                      "id"=> $this->id_city,
                      "name"=>  $this->city,
                      "links" => env('APP_URL')."/api/cities"
                    ]
                ],
                "state"=>[ 
                    "data"=>[
                      "type"=> "state",
                      "id"=>  $this->id_state,
                      "name"=>  $this->state,
                      "links" => env('APP_URL')."/api/states"
                    ]
                ]
            ],
        ];
    }
}