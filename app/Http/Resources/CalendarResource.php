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
        return [
            "data" => [
                "type" => "calendar",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'start_date',
                    'end_date',
                    'notes',
                    'job_id',
                    'employee_id'
                )
            ],

        ];
    }
}
