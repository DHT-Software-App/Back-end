<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
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
                "type" => "calendars",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'start_date',
                    'end_date',
                    'notes',
                    'created_at',
                    'updated_at'
                ),
                "relationships" => [
                    "employee" => [
                        "links" => [
                            "related" => url("/api/v1/calendars/{$this->id}/employee")
                        ],
                        "data" => [
                            "type" => "employees",
                            "id" => (string) $this->employee->id
                        ]
                    ],
                    "job" => [
                        "links" => [
                            "related" => url("/api/v1/calendars/{$this->id}/job")
                        ],
                        "data" => [
                            "type" => "jobs",
                            "id" => (string) $this->job->id
                        ]
                    ],
                ]
            ],
            "included" => array_merge(
                [$this->mergeWhen(in_array('employee', $includes), [
                    (new EmployeeResource($this->employee))
                ])],
                [$this->mergeWhen(in_array('job', $includes), [
                    (new JobResource($this->job))
                ])]
            )

        ];
    }
}
