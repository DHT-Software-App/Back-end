<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
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
                "type" => "profiles",
                "id" => (string) $this->id,
                "attributes" => array_merge(
                    $this->only(['nickname']),
                    [
                        'url' => $this->when($this->image, function () {
                            return Storage::disk('s3')->url($this->image->url);
                        })
                    ]
                ),
                "relationships" => [
                    "user" => [
                        "links" => [
                            "related" => url("/api/v1/profiles/{$this->id}/user"),
                        ],
                        "data" => [
                            "type" => "users",
                            "id" => (string) $this->user->id,
                        ]
                    ]
                ]
            ]
        ];
    }
}
