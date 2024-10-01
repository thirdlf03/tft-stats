<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'result_id',
        'content',
        'image_url'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
