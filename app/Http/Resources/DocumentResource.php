<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $includes = split_by_comma(request()->query('include'));

        return [
            "data" => [
                "type" => "document",
                "id" => (string) $this->id,
                "attributes" => array_merge($this->only(
                    'description',
                ), [
                    'url' => Storage::disk('s3')->url($this->image->url)
                ]),
                "relationships" => [
                    "job" => [
                        "links" => [
                            "related" => url("/api/v1/documents/{$this->id}/job"),
                        ],
                        "data" => [
                            "type" => "jobs",
                            "id" => (string) $this->job->id,
                        ]
                    ]
                ]
            ],
            "included" => array_merge(
                [$this->mergeWhen(in_array('job', $includes), [
                    (new JobResource($this->job))
                ])],
            )
        ];
    }
}
