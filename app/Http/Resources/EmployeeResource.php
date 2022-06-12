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
                      "links" => env('APP_URL')."/api/cities"
                    ]
                ],
                "state"=>[ 
                    "data"=>[
                      "type"=> "state",
                      "id"=>  $this->id_state,
                      "links" => env('APP_URL')."/api/states"
                    ]
                ],
                "contact"=>[ 
                    "data"=>[
                      "type"=> "contact and ",
                      "links"=> env('APP_URL')."/api/employees/detailscontact/",
                      "message" => "this link recivied id employees"
                    ]
                ],
        ],
            'employee_status'  => $this->employee_status,
        ];
        // return [
        //     'id' => $this->id,
        //     'first_name' => $this->first_name,
        //     'last_name' => $this->last_name,
        //     'email' => $this->email,
        //     'street' => $this->street,
        //     'id_city' => $this->id_city,
        //     'id_state' => $this->id_state,
        //     'zip' => $this->zip,
        //     'origin' => $this->origin,
        // ];
    }
}