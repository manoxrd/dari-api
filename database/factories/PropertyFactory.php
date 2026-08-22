<?php

namespace Database\Factories;

use App\Enums\PropertyPurpose;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'thumbnail' => fake()->imageUrl(),
      'title' => fake()->jobTitle(),
      'user_id' => User::factory(),
      'description' => fake()->realText(),
      'price' => fake()->numberBetween(1, 10),
      'area' => fake()->numberBetween(20, 30),
      'bedrooms' => fake()->numberBetween(1,6),
      'bathrooms' => fake()->numberBetween(1,3),
      'purpose' => Arr::random(PropertyPurpose::cases()),
    ];
  }
}
