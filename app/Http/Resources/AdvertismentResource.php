<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertismentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>$this->id,   
            "user_id" =>$this->user_id,    
            "type" =>$this->type,
            "salary" => $this->salary,
            "rooms"     => $this->rooms,
            "bath_room"     => $this->bath_room,
            "area"    => $this->area,
            "evaluation" => $this->evaluation,
            "state" => $this->state,
            "duration"     => $this->duration,
            "location"    => $this->location,
            "description" => $this->description,
            "advertisment_type" => $this->advertisment_type,
            "photo" => ImagesResource::collection($this->getMedia('advertisment')),
        ];
    }
}
