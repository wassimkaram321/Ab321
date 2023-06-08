<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = ['title', 'body'];

    // many to many
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notification', 'notification_id' ,'user_id');
    }

    public function scopeApp($query)
    {
        $user = Auth::user();
        if($user->role_id == 1)
            return $query->get();
        else
            return $user->notifications;
    }

}
