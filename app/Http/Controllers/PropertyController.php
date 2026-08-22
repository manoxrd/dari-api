<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $perPage = min($request->integer('per_page', 15), 30);

    return PropertyResource::collection(Property::paginate($perPage));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StorePropertyRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Property $property)
  {
    return new PropertyResource($property);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Property $property)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatePropertyRequest $request, Property $property)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Property $property)
  {
    //
  }
}
