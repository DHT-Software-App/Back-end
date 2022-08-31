<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
                "type" => "document",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'description',
                    'url',
                    'job_id',
                    'document_type_id'
                )
            ],

        ];
    }
}
