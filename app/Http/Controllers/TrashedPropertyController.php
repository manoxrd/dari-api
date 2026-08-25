<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class TrashedPropertyController extends Controller
{
  public function index(Request $request)
  {
    if ($request->user()->cannot('viewTrashed', Property::class)) abort(403);


    $validated = $request->validated();

    $perPage = $request->integer('per_page', 15);

    $price_range = [
      'min' => $validated['min_price'] ?? null,
      'max' => $validated['max_price'] ?? null
    ];

    $properties = Property::onlyTrashed()->when($validated['purpose'] ?? null, fn($query, $value) => $query->where('purpose', $value))
      ->when($validated['bathrooms'] ?? null, fn($query, $value) => $query->where('bathrooms', $value))
      ->when($validated['bedrooms'] ?? null, fn($query, $value) => $query->where('bedrooms', $value))
      ->when(array_filter($price_range), fn($query, array $price) => $query->whereBetween('price', $price))
      ->with('user')->paginate($perPage)->withQueryString();

    return PropertyResource::collection($properties);
  }

  public function restore(Request $request, Property $property)
  {
    if ($request->user()->cannot('restore', $property)) abort(403);
    if (!$property->trashed()) return response(['message' => "This isn't a trashed property"], 422);

    $property->restore();

    return new PropertyResource($property);
  }

  public function forceDelete(Request $request, Property $property)
  {
    if ($request->user()->cannot('forceDelete', $property)) abort(403);
    if (!$property->trashed()) return response(['message' => "This isn't a trashed property"], 422);

    $property->forceDelete();

    return response()->noContent();
  }
}
