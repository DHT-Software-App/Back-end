<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
                "type" => "jobs",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'policy_number',
                    'claim_number',
                    'notes',
                    'date_of_loss',
                    'type_of_loss',
                    'status',
                    'state',
                    'street',
                    'city',
                    'zip',
                    'company',
                    'created_at',
                    'updated_at'
                ),
                "relationships" => [
                    "customer" => [
                        "links" => [
                            "related" => url("/api/v1/jobs/{$this->id}/customer")
                        ],
                        "data" => [
                            "type" => "customers",
                            "id" => (string) $this->customer->id
                        ]
                    ],
                    "client" => [
                        "links" => [
                            "related" => url("/api/v1/jobs/{$this->id}/client")
                        ],
                        "data" => [
                            "type" => "clients",
                            "id" => (string) $this->client->id
                        ]
                    ],
                    "work_type" => [
                        "links" => [
                            "related" => url("/api/v1/jobs/{$this->id}/workType")
                        ],
                        "data" => [
                            "type" => "work_types",
                            "id" => (string) $this->workType->id
                        ]
                    ],
                    "insurance" => [
                        "links" => [
                            "related" => url("/api/v1/jobs/{$this->id}/insurance")
                        ],
                        "data" => [
                            "type" => "insurances",
                            "id" => (string) $this->insurance->id
                        ]
                    ],
                ]
            ],
            "included" => array_merge(
                [$this->mergeWhen(in_array('customer', $includes), [
                    (new CustomerResource($this->customer))
                ])],
                [$this->mergeWhen(in_array('client', $includes), [
                    (new ClientResource($this->client))
                ])],
                [$this->mergeWhen(in_array('work_type', $includes), [
                    (new WorkTypeResource($this->workType))
                ])],
                [$this->mergeWhen(in_array('insurance', $includes), [
                    (new InsuranceResource($this->insurance))
                ])],
            )

        ];
    }
}
