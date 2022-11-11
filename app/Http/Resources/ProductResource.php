<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "image" => $this->image,
            "title" => $this->title,
            "slug" => $this->slug,
            "category_id" => $this->category_id,
            "content" => $this->content,
            "weight" => $this->weight,
            "price" => $this->price,
            "discount" => $this->discount ?? 0
        ];
    }
}