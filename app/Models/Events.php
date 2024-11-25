<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    
    

    protected $fillable = ['user_id', 'title', 'description', 'start_time', 'end_time'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'attendees','event_id','user_id',);
    }

}
