<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {

    return [
      'id' => $this->id,
      'thumbnail_url' => $this->thumbnail_url,
      'title' => $this->title,
      'description' => $this->description,
      'price' => (float) $this->price,
      'area' => (float) $this->area,
      'bedrooms' => $this->bedrooms,
      'bathrooms' => $this->bathrooms,
      'purpose' => $this->purpose,
      'listed_on' => $this->created_at->format('M d, Y'),
    ];
  }
}
