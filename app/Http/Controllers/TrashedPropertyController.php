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

    $per_page = min($request->integer('per_page', 15), 30);

    $properties = Property::onlyTrashed()
    ->when($request->purpose, fn($query, $value) => $query->where('purpose', $value))
    ->when($request->bathrooms, fn($query, $value) => $query->where('bathrooms', $value))
    ->when($request->bedrooms, fn($query, $value) => $query->where('bedrooms', $value))
    ->with('user')->paginate($per_page)->withQueryString();

    return PropertyResource::collection($properties);
  }
}
