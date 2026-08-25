<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[Fillable(['thumbnail', 'title', 'description', 'price', 'area', 'bedrooms', 'bathrooms', 'purpose'])]
class Property extends Model
{
  /** @use HasFactory<\Database\Factories\PropertyFactory> */
  use HasFactory, SoftDeletes;

  protected $appends = ['thumbnail_url'];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  #[Scope]
  protected function filters(Builder $query, array $data, array $price_range): Builder
  {
    return $query
      ->when($data['purpose'] ?? null, fn($q, $v) => $q->where('purpose', $v))
      ->when($data['bathrooms'] ?? null, fn($q, $v) => $q->where('bathrooms', $v))
      ->when($data['bedrooms'] ?? null, fn($q, $v) => $q->where('bedrooms', $v))
      ->when(array_filter($price_range), fn($q, array $price) => $q->whereBetween('price', $price));
  }

  protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(
          fn () => $this->thumbnail 
          ? Storage::disk('public')->url($this->thumbnail)
          : ''
        );
    }
}
