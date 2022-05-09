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

        // dd((new PermissionCollection($this->getAllPermissions()))->collection);

        return [
            "data" => [
                "type" => "users",
                "id" => (string) $this->id,
                "attributes" => $this->only('email','created_at','updated_at'),
                "relationships" => [
                    "employee" => [
                        "links" => [
                           "related" => url("/api/v1/auth/me/employee")  
                        ],
                        "data" => [
                            "type" => "employees",
                            "id" => (string) $this->employee->id,
                        ] 
                    ],
                    "employees" => [
                        "links" => [
                            "related" => url("/api/v1/auth/me/employees")  
                         ],
                         "data" => $this->when(
                            $this->creatorEmployees, 
                            $this->creatorEmployees->map(function($employee) {
                                return [
                                    "type" => "employees",
                                    "id" => (string) $employee->id
                                ];
                            })
                         )
                    ],
                    "profile" => [
                        "links" => [
                            "related" => url("/api/v1/auth/me/profile"),
                        ],
                        "data" => [
                            "type" => "profiles",
                            "id" => (string) $this->profile->id,
                        ] 
                    ],
                    "role" => [
                        "links" => [
                            "self" => url("/api/v1/auth/me/relationships/role"),
                            "related" => url("/api/v1/auth/me/role"),
                        ],
                        "data" => [
                            "type" => "roles",
                            "id" => (string) $this->roles->first()->id,
                        ]
                    ],
                    "permissions" => [
                        "data" => $this->getAllPermissions()->map(function($permission) { 
                                    return [ "type" => "permissions", "id" => $permission->id ]; 
                                })
                    ]

                ]
            ],
            "included" => array_merge(
                [new EmployeeResource($this->employee)],
                [new ProfileResource($this->profile)],
                [new RoleResource($this->roles->first())],
                (new PermissionCollection($this->getAllPermissions()))->collection->toArray()
            )
        ];
    }
}
