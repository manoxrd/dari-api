<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
  public function index(Request $request)
  {
    $perPage = min($request->integer('per_page', 15), 30);

    return PropertyResource::collection(Property::with('user')->paginate($perPage));
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

    if($request->user()->cannot('update', $property)) abort(403);

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

  public function destroy(Property $property) {
    
    $property->delete();
    return response()->noContent();
  }
}
