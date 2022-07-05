<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        var_dump($request);
        die();
        // return [
        //     "types"=>"name Permission",
        //     'rol' => [
        //         'id'   => $this->idRol,
        //         'name' => $this->nameRol,
        //     ],
        //     "details"=>[
        //         "Permission"=>[ 
        //             "data"=>[
        //               "type"=> "Permission",
        //               "id"=> $this->id,
        //               "links" => env('APP_URL')."/api/permission/{id}"
        //             ]
        //         ]
        //     ]
        // ];
    }
}