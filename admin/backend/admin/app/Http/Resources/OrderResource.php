<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'totalAmount' => $this->totalAmount,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'postal_code' => $this->postal_code,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'payment_id' => $this->payment_id,
            'payment_amount' => $this->payment_amount,
            'payment_currency' => $this->payment_currency,
            'payment_description' => $this->payment_description,
            'payment_status_detail' => $this->payment_status_detail,
            'payment_created_at' => $this->payment_created_at,
            'payment_updated_at' => $this->payment_updated_at,
            'payment_transaction_id' => $this->payment_transaction_id,
            'payment_transaction_type' => $this->payment_transaction_type,
            'payment_transaction_status' => $this->payment_transaction_status,
            'payment_transaction_amount' => $this->payment_transaction_amount,
            'payment_transaction_currency' => $this->payment_transaction_currency,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
