<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
                "type" => "employees",
                "id" => $this->id,
                "attributes" => $this->only(
                    'firstname',
                    'lastname',
                    'email_address',
                    'contact_1',
                    'contact_2',
                    'state',
                    'street',
                    'city',
                    'zip',
                    'status',
                    'created_by',
                    'created_at',
                    'updated_at'
                )
            ]
        ];
    }
}
