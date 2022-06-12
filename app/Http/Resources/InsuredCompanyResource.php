<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InsuredCompanyResource extends JsonResource
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
            'id' => $this->id,
            'company' => $this->company,
            'street' => $this->street,
            'id_city' => $this->id_city,
            'id_state' => $this->id_state,
            'zip' => $this->zip,
        ];
    }
}