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
        // Users can view their own cars
        return true;
    }

    /**
     * Determine whether the user can view a specific car.
     */
    public function view(User $user, Car $car): bool
    {
        // Only allow the owner to view
        return $user->id === $car->user_id;
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
        // Only allow the owner to update
        return $user->id === $car->user_id;
    }

    /**
     * Determine whether the user can delete the car.
     */
    public function delete(User $user, Car $car): bool
    {
        // Only allow the owner to delete
        return $user->id === $car->user_id;
    }
}
