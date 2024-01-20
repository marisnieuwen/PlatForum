<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'is_banned',
        'is_admin',
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
        'password' => 'hashed',
    ];

    // Define relationship with threads 
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    // Define relationship with likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    // Check if a user has liked a specific thread
    public function hasLiked(Thread $thread)
    {
        return $this->likes()->where('thread_id', $thread->id)->exists();
    }

    // Define relationship with liked threads
    public function likedThreads()
    {
        return $this->belongsToMany(Thread::class, 'likes');
    }


    // Define relationship with roles
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    // Check if a user has a specific role
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }


    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
