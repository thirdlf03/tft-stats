<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookmark_contents()
    {
        return $this->belongsToMany(Result::class, 'bookmark_contents', 'bookmark_id', 'result_id');
    }
}
