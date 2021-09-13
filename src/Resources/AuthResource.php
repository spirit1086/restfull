<?php

namespace Spirit1086\Restfull\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'bearer_token' => $this->bearer_token,
            'token_type' => $this->token_type,
            'expires_in'=>$this->expires_in
        ];
    }
}
