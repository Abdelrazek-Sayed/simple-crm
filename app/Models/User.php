<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER  = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
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

    // public function setPasswordAttribute()
    // {
    //     $this->attributes['password'] = bcrypt($this->password);
    // } 

    public function getImageUrlAttribute()
    {
        if($this->image && Storage::disk('images')->exists($this->image)){
            // return Storage::disk('images')->url($this->image);
            return asset('storage/images/'.$this->image);
        }
        return asset('storage/images/user.png');
    }

    public function isAdmin()
    {
        if($this->role == self::ROLE_ADMIN){

            return true;
        }
        return false;
    }
}
