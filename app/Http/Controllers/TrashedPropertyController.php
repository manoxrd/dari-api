<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Http\Requests\FilterPropertyRequest;
use Illuminate\Http\Request;

class TrashedPropertyController extends Controller
{
  public function index(FilterPropertyRequest $request)
  {
    if ($request->user()->cannot('viewTrashed', Property::class)) abort(403);

    $validated = $request->validated();

    $perPage = $request->integer('per_page', 15);

    $price_range = [
      'min' => $validated['min_price'] ?? null,
      'max' => $validated['max_price'] ?? null
    ];

    $properties = Property::onlyTrashed()
      ->filters($validated, $price_range)
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
    if ($request->user()->cannot('forceDelete', Property::class)) abort(403);
    if (!$property->trashed()) return response(['message' => "This isn't a trashed property"], 422);

    $property->forceDelete();

    return response()->noContent();
  }
}
