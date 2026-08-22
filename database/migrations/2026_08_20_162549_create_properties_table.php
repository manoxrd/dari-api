<?php

use App\Enums\PropertyPurpose;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('properties', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
      $table->string('thumbnail');
      $table->string('title');
      $table->text('description')->nullable();
      $table->decimal('price', 12, 2);
      $table->decimal('area', 10, 2);
      $table->unsignedTinyInteger('bedrooms')->nullable();
      $table->unsignedTinyInteger('bathrooms')->nullable();
      $table->enum('purpose', PropertyPurpose::cases());
      $table->boolean('is_approved')->default(false);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('properties');
  }
};
