<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transport extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this -> type,
            'capacity' => $this ->capacity,
            'instruments_capacity' => $this -> instruments_capacity,
            'disponibility' => $this -> disponibility,
            'licence_plate' => $this -> licence_plate,
            'calendar' =>  "/calendarios/" . $this -> calendar_id,
        ];
    }
}
