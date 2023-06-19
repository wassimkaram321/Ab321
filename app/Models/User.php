<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function stories()
    {
        return $this->belongsToMany(Story::class, 'story_user');
    }

    // many to many
    public function favoriteVendors()
    {
        return $this->belongsToMany(Vendor::class, 'favorite_vendors', 'user_id', 'vendor_id')
            ->where('is_active', 1);
    }

    public function reels()
    {
        return $this->belongsToMany(Reel::class, 'reel_user');

    }

    // many to many
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notification', 'user_id', 'notification_id')
            ->withPivot(['seen', 'seen_at']);

    }
    public static function booted()
    {
        static::retrieved(function ($user) {
            if($user->avatar!=null)
                $user->avatar = asset('images/users/' . $user->avatar);
        });
        static::updating(function ($user) {
            if($user->avatar){
                $user->avatar = basename($user->avatar);
            }
        });
    }
}
