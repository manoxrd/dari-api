<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{

  public function viewTrashed(User $user) {
    return $user->role === UserRole::Admin->value;
  }

  public function update(User $user, Property $property): bool
  {
    return $user->id === $property->user_id || $user->role === UserRole::Admin->value;
  }

  public function delete(User $user, Property $property): bool
  {
    return $user->id === $property->user_id || $user->role === UserRole::Admin->value;
  }

  public function restore(User $user, Property $property): bool
  {
    return $user->id === $property->user_id || $user->role === UserRole::Admin->value;
  }

  public function forceDelete(User $user): bool
  {
    return $user->role === UserRole::Admin->value;
  }
}
