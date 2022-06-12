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
            'id' => $this->id,
            'id_jobs' => $this->id_jobs,
            'id_technician' => $this->id_technician,
            'date_start_job' => $this->date_start_job,
            'date_finish_job' => $this->date_finish_job,
            'note' => $this->note
        ];
    }
}