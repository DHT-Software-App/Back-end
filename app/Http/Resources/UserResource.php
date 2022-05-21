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
        $includes = split_by_comma(request()->query('include'));
 

        return [
            "data" => [
                "type" => "users",
                "id" => (string) $this->id,
                "attributes" => $this->only('email', 'email_verified_at', 'created_at','updated_at'),
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
                    ]
                ]
            ],
            "included" => array_merge(
               [$this->mergeWhen($this->profile && in_array('profile', $includes), [
                    [new ProfileResource($this->profile)],
                ])]
            )
        ];
    }
}
