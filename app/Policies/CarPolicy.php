<?php
namespace App\Policies;
use App\Models\User;
use App\Models\Car;

class CarPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Car $car): bool
    {
        return (bool)$user->is_admin || (int)$user->id === (int)$car->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Car $car): bool
    {
        return (bool)$user->is_admin || (int)$user->id === (int)$car->user_id;
    }

    public function delete(User $user, Car $car): bool
    {
        return (bool)$user->is_admin || (int)$user->id === (int)$car->user_id;
    }
}
