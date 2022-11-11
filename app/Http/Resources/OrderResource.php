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
            "id" => $this->id,
            "invoice" => $this->invoice,
            "customer_id" => $this->customer_id,
            "courier" => $this->courier,
            "service" => $this->service,
            "cost_courier" => $this->cost_courier,
            "weight" => $this->weight,
            "name" =>  $this->name,
            "phone" => $this->phone,
            "province_id" => $this->province_id,
            "city_id" => $this->city_id,
            "address" => $this->address,
            "status" => $this->status,
            "snap_token" => $this->snap_token,
            "grand_total" => $this->grand_total,
        ];
    }
}