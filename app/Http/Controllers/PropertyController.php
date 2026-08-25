<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterPropertyRequest;
use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
  public function index(FilterPropertyRequest $request)
  {

    $validated = $request->validated();
    
    $perPage = $request->integer('per_page', 15);

    $price_range = [
      'min' => $validated['min_price'] ?? null,
      'max' => $validated['max_price'] ?? null
    ];

    $properties = Property::when($validated['purpose'] ?? null, fn($query, $value) => $query->where('purpose', $value))
      ->when($validated['bathrooms'] ?? null, fn($query, $value) => $query->where('bathrooms', $value))
      ->when($validated['bedrooms'] ?? null, fn($query, $value) => $query->where('bedrooms', $value))
      ->when(array_filter($price_range), fn($query, array $price) => $query->whereBetween('price', $price))
      ->with('user')->paginate($perPage)->withQueryString();

    return PropertyResource::collection($properties);
  }

  public function store(StorePropertyRequest $request)
  {
    $validated = $request->validated();

    if ($request->hasFile('thumbnail')) {

      $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
    } else {
      unset($validated['thumbnail']);
    }

    $property = $request->user()->properties()->create($validated);

    return (new PropertyResource($property))
      ->response()
      ->setStatusCode(201);
  }

  public function show(Property $property)
  {
    $property->load('user');
    return new PropertyResource($property);
  }

  public function update(UpdatePropertyRequest $request, Property $property)
  {

    if ($request->user()->cannot('update', $property)) abort(403);

    $validated = $request->validated();

    if ($request->hasFile('thumbnail')) {

      Storage::disk('public')->delete($property->thumbnail);

      $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
    } else {
      unset($validated['thumbnail']);
    }

    $property->update($validated);

    return new PropertyResource($property)->response();
  }

  public function destroy(Property $property)
  {
    if (auth()->guard()->user()->cannot('delete', $property)) abort(403);

    $property->delete();
    return response()->noContent();
  }
}
