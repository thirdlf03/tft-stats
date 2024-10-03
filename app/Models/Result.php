<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['data_json', 'user_id', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function bookmark_contents()
    {
        return $this->belongsToMany(Bookmark::class, 'bookmark_contents', 'result_id', 'bookmark_id', );
    }
}
