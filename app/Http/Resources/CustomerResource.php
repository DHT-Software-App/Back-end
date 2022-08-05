<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
                "type" => "customers",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'firstname',
                    'lastname',
                    'insured_firstname',
                    'insured_lastname',
                    'email_address',
                    'contact_1',
                    'contact_2',
                    'state',
                    'street',
                    'city',
                    'zip',
                    'has_insured'
                )
            ],

        ];
    }
}
