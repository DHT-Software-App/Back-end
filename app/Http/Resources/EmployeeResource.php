<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            "types"=>"Employees",
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
                      "name"=> $this->city,
                      "links" => env('APP_URL')."/api/cities"
                    ]
                ],
                "state"=>[ 
                    "data"=>[
                      "type"=> "state",
                      "id"=>  $this->id_state,
                      "state"=> $this->state,
                      "links" => env('APP_URL')."/api/states"
                    ]
                ],
                "contact"=>[ 
                    "data"=>[
                      "type"    => "contact",
                      "links"   => env('APP_URL')."/api/employees/detailscontact/",
                      "contact" => $this->contact,
                      "message" => "this link recivied id employees"
                    ]
                ],
        ],
            'employee_status'  => $this->employee_status,
        ];
    }
}