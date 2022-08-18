<?php

namespace App\Http\Resources;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'email' => $this->email,
            // $this->mergeWhen(Auth::user() && $this->isAdmin(), [
                // 'role' => $this->role->name,
                // 'influencer' => new InfluencerResource($this->influencer),
            // ]),
            // $this->mergeWhen(Auth::user() && $this->isInfluencer(), [
            //     'revenue' => $this->revenue,
                
            // ]),
        ];
    }
}
