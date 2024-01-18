<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\User;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'rank'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
