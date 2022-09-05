<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Microservices\UserService;

class LinkResource extends JsonResource
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
            'link' => $this->link,
            'user'=>  (new UserService())->get($this->user_id),  //new UserResource($this->user),
            'products' => ProductResource::collection($this->products),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
