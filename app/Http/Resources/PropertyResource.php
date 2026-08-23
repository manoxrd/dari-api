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
      'can' => $this->when($request->routeIs('v1.properties.show'), fn() => [
        'update' => $request->user()?->can('update', $this->resource),
        'delete' => $request->user()?->can('delete', $this->resource),
      ]),
      'deleted_at' => $this->when($request->routeIs('v1.properties.trashed'), fn() => $this->deleted_at)
    ];
  }
}
