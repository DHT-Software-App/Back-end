<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            "data" => [
                "type" => "profiles",
                "id" => (string) $this->id,
                "attributes" => array_merge(
                    $this->only(['nickname']), 
                    [
                        'url' => $this->when($this->image, function(){
                            return $this->image->url;
                        }) 
                    ]
                )
            ]
        ];
    }
}
