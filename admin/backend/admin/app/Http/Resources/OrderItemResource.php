<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            // 'product_id' => $this->product_id,
            'product_name' => $this->name,
            // 'order_id' => $this->order_id,
            // 'quantity' => (int) $this->quantity,
            'price' => (float) $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        
        ];
    }
}
