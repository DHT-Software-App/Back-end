<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstimateItemResource extends JsonResource
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
                "type" => "estimate_items",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'name',
                    'price',
                    'unit',
                    'item_type',
                    'created_at',
                    'updated_at'
                ),
                "relationships" => [
                    "work_type" => [
                        "links" => [
                            "related" => url("/api/v1/estimate_items/{$this->id}/work_type")
                        ],
                        "data" =>  $this->when($this->workType, function () {
                            return [
                                "type" => "work_types",
                                "id" => (string) $this->workType->id
                            ];
                        })
                    ]
                ]
            ],
            "included" => array_merge(
                [
                    $this->mergeWhen($this->workType && in_array('work_type', $includes), [
                        new WorkTypeResource($this->workType)
                    ])
                ]
            )

        ];
    }
}
