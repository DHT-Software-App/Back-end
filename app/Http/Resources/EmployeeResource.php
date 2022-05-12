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
        $includes = split_by_comma(request()->query('include'));

        return  [
                "data" => [
                    "type" => "employees",
                    "id" => (string) $this->id,
                    "attributes" => $this->only(
                        'firstname',
                        'lastname',
                        'email_address',
                        'contact_1',
                        'contact_2',
                        'state',
                        'street',
                        'city',
                        'zip',
                        'status',
                        'created_at',
                        'updated_at'
                    ),
                    "relationships" => [
                        "user" => [
                            "links" => [
                                "related" => url("/api/v1/employees/{$this->id}/user")
                            ],
                            "data" => $this->when($this->user, function() {
                                return [
                                    "type" => "users",
                                    "id" => (string) $this->user->id
                                ];
                            })
                        ],
                        "role" => [
                            "links" => [
                                "self" => url("/api/v1/employees/{$this->id}/relationships/role"),
                                "related" => url("/api/v1/employees/{$this->id}/role")
                            ],
                            "data" => $this->when($this->roles, function() {
                                return [
                                    "type" => "roles",
                                    "id" => (string) $this->roles->first()->id
                                ];
                            })
                        ]
                        
                    ]
                ],
                "included" => array_merge(
                    [$this->mergeWhen($this->user && in_array('user', $includes), [
                        (new UserResource($this->user))
                    ])]
                )
            ];

            // TODO
            // (new AbilityCollection($this->getAbilities()))->collection->toArray()

    }
}
