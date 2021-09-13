<?php

namespace Spirit1086\Restfull\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'active'=>$this->active ? true:false,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
