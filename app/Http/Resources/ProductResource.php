<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           'id'=>$this->id,
           'name'=>$this->name,
           'is_favorite'=>$this->is_favorite,
           'category'=>new CategoryResource($this->category),
           'images'=>ProductImageResource::collection($this->images),
       ];
    }
}
