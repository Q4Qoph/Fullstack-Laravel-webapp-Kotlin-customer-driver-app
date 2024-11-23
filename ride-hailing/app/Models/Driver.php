<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory,Notifiable;

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
        'status', // Holds 'online' or 'offline'
    ];

    // Relationship with Ride
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    // Accessor for status
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Returns "Online" or "Offline"
    }

    // Helper method to check if driver is online
    public function isOnline()
    {
        return $this->status === 'online';
    }

//     // Helper method to set status as online
//     public function setOnline()
//     {
//         $this->update(['status' => 'online']);
//     }

//     // Helper method to set status as offline
//     public function setOffline()
//     {
//         $this->update(['status' => 'offline']);
//     }
}
