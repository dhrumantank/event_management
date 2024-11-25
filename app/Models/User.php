<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
    use App\Models\Events;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
 
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function createdEvents()
    {
        return $this->hasMany(Events::class);
    }

    
    public function attendingEvents()
    {
        return $this->belongsToMany(Events::class, 'attendees', 'user_id', 'event_id','id');
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
