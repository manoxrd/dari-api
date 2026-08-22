<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['thumbnail', 'title', 'description', 'price', 'area', 'bedrooms', 'bathrooms', 'purpose'])]
class Property extends Model
{
  /** @use HasFactory<\Database\Factories\PropertyFactory> */
  use HasFactory;

  protected $appends = ['thumbnail_url'];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
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
