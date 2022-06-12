<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobsResource extends JsonResource
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
            'id_customers' => $this->id_customers,
            'id_insurance_company' => $this->id_insurance_company,
            'policy_number' => $this->policy_number,
            'claim_number' => $this->claim_number,
            'date_loss' => $this->date_loss,
            'id_type_loss' => $this->id_type_loss,
            'text' => $this->text,
            'referred_by' => $this->referred_by,
            'id_job_status' => $this->id_job_status,
            'id_type_work' => $this->id_type_work,
        ];
    }
}