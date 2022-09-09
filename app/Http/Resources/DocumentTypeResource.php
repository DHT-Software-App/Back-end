<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentTypeResource extends JsonResource
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
                "type" => "document_types",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'name',
                ),
                "relationships" => [
                    "documents" => [
                        "links" => [
                            "related" => url("/api/v1/document_types/{$this->id}/documents")
                        ],
                        "data" => $this->documents()->pluck('id')->map(function ($id) {
                            return [
                                "type" => "documents",
                                "id" => (string) $id
                            ];
                        })
                    ]
                ]
            ],
            "included" => array_merge(
                [$this->mergeWhen(
                    in_array('documents', $includes),
                    DocumentCollection::collection($this->documents),
                )]
            )
        ];
    }
}
