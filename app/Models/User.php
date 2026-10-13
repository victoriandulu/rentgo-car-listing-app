<?php

namespace App\Models;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',        // was missing: the profile form's phone number was silently not saved
        'password',
        'google_id',
        'avatar',
        'email_verified_at',
        'is_admin',
        'is_verified',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin'          => 'boolean',
        'is_verified'       => 'boolean',
    ];

    /**
     * Boot model events
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->email = trim($user->email);

            if ($user->is_admin) {
                $user->is_verified = true;
            }
        });

        static::updating(function ($user) {
            $user->email = trim($user->email);

            if ($user->is_admin) {
                $user->is_verified = true;
            }
        });
    }

    /**
     * First name: use the saved value, otherwise derive it from "name".
     * Fixes users who registered / logged in with Google (only "name" was saved).
     */
    public function getFirstNameAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        $parts = explode(' ', trim($this->attributes['name'] ?? ''), 2);

        return $parts[0] !== '' ? $parts[0] : null;
    }

    /**
     * Last name: use the saved value, otherwise derive it from "name".
     */
    public function getLastNameAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        $parts = explode(' ', trim($this->attributes['name'] ?? ''), 2);

        return $parts[1] ?? null;
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Check if user is verified by admin
     */
    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    /**
     * Relation to verification documents
     */
    public function verification()
    {
        return $this->hasOne(UserVerification::class);
    }

    /**
     * Relation to cars
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
