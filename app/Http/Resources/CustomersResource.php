<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //Convert data group to array
      
        
         return [
            "types"=>"Customers",
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
                ],
                "contact"=>[ 
                    "data"=>[
                      "type"=> "contact and ",
                      "links"=> env('APP_URL')."/api/customers/detailscontact/",
                      "message" => "this link recivied id customers"
                    ]
                ],
                 "insured"=>[ 
                    "data"=>[
                        "type"=> "insured",
                        "links"=> env('APP_URL')."/api/customers/detailsinsured/",
                        "message" => "this link recivied id customers"
                    ]
                ]

                
        ],
            'customer_status'  => $this->customer_status,
        ];
    }
}