<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
                "type" => "clients",
                "id" => (string) $this->id,
                "attributes" => $this->only(
                    'firstname',
                    'lastname',
                    'email_address_1',
                    'email_address_2',
                    'contacts',
                    'state',
                    'street',
                    'city',
                    'zip',
                    'company',
                )
            ],

        ];
    }
}
