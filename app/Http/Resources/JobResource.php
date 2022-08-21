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
        return [
            "data" => [
                "type" => "jobs",
                "id" => (string) $this->id,
                "attributes" => $this->only(
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
                    'employee_id',
                    'customer_id',
                    'client_id',
                    'work_type_id',
                    'insurance_id',
                    'created_at',
                    'updated_at'
                )
            ],

        ];
    }
}
