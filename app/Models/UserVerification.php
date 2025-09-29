<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'driver_license',
        'proof_of_address',
        'additional_docs',
        'national_id',
        'photo',
        'verification_video',
    ];

    protected $casts = [
        'additional_docs' => 'array', // auto-cast JSON to array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
