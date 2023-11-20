<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data= [
            'id' => $this->id,
            'name' => $this->name,
            'images' =>new ImagesResource($this->images->first()),
            'price' => $this->price,
            'discount' => $this->discount,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
        if ($request->route()->getName() == 'products.show') {
            $data['images'] = ImagesResource::collection($this->whenLoaded('images')->paginate(5));
        }
        return $data;
    }
}
