<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkTypeResource extends JsonResource
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
                "type" => "work_types",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'name',
                    'created_at',
                    'updated_at'
                ),
                "relationships" => [
                    "estimate_items" => [
                        "links" => [
                            "related" => url("/api/v1/work_types/{$this->id}/estimate_items")
                        ],
                        "data" => $this->estimateItems()->pluck('id')->map(function ($id) {
                            return [
                                "type" => "estimate_items",
                                "id" => (string) $id
                            ];
                        })
                    ]
                ]
            ],
            "included" => array_merge(
                [$this->mergeWhen(
                    in_array('estimate_items', $includes),
                    EstimateItemResource::collection($this->estimateItems),
                )]
            )
        ];
    }
}
