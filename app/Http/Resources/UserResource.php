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
                "links" => [
                    "self" => url("/api/v1/users/{$this->id}")
                ],
                "relationships" => [
                    "profile" => [
                        "links" => [
                            "related" => url("/api/v1/users/{$this->id}/profile"),
                        ],
                        "data" => [
                            "type" => "profiles",
                            "id" => (string) $this->profile->id,
                        ] 
                    ],
                    "role" => [
                        "links" => [
                            "self" => url("/api/v1/users/{$this->id}/relationships/role"),
                            "related" => url("/api/v1/users/{$this->id}/role"),
                        ],
                        "data" => $this->when($this->roles->first(), function() {
                            return [
                                "type" => "roles",
                                "id" => (string) $this->roles->first()->id,
                            ];
                        }) 
                    ],
                    "permissions" => [
                        "links" => [
                            "related" => url("/api/v1/users/{$this->id}/permissions"),
                        ],
                        "data" => $this->getAllPermissions()->map(function($permission) { 
                                    return [ "type" => "permissions", "id" => $permission->id ]; 
                        })
                    ]

                ]
            ],
            "included" => array_merge(
                [new ProfileResource($this->profile)],
                [new RoleResource($this->roles->first())],
                (new PermissionCollection($this->getAllPermissions()))->collection->toArray()
            )
        ];
    }
}
