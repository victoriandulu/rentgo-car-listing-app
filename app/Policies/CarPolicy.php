<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Car;

class CarPolicy
{
    /**
     * Determine whether the user can view any cars.
     */
    public function viewAny(User $user): bool
    {
        // Any authenticated user can view cars
        return true;
    }

    /**
     * Determine whether the user can view a specific car.
     */
    public function view(User $user, Car $car): bool
    {
        // Admins can view any car, users can view their own
        return $user->is_admin || $user->id === $car->user_id;
    }

    /**
     * Determine whether the user can create a car.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a car
        return true;
    }

    /**
     * Determine whether the user can update the car.
     */
    public function update(User $user, Car $car): bool
    {
        // Admins can update any car, users can update their own
        return $user->is_admin || $user->id === $car->user_id;
    }

    /**
     * Determine whether the user can delete the car.
     */
    public function delete(User $user, Car $car): bool
    {
        // Admins can delete any car, users can delete their own
        return $user->is_admin || $user->id === $car->user_id;
    }
}
