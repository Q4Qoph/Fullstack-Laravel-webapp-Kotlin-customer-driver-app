<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;


class Customer extends Authenticatable
{
    use HasApiTokens,HasFactory;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone',
        'pin', // Assuming it's hashed
        'gender',
        'email',
        'county',
        'sub_county',
    ];

    // Relationship with Ride
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
