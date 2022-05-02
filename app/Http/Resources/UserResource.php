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
            "data" => [
                "type" => "users",
                "id" => (string) $this->id,
                "attributes" => $this->only('email','created_at','updated_at'),
                "relationships" => [
                    "employee" => [
                        "links" => [
                           "self" => "http://api.com/users/{$this->id}/relationships/employees",
                           "related" => "http://api.com/users/{$this->id}/employees"  
                        ],
                        "data" => [
                            "type" => "employees",
                            "id" => (string) $this->employee->id,
                        ] 
                    ],
                    "profile" => [
                        "data" => [
                            "type" => "profiles",
                            "id" => (string) $this->profile->id,
                        ] 
                    ],
                    "roles" => [],

                ],
                "links" => [
                    "self" => "http://api.com/users/{$this->id}"
                ]
            ]
        ];
    }
}
