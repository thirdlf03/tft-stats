<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = ['name']

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookmark_contents()
    {
        return $this->belongsToMany(Bookmark::class, 'bookmark_contents');
    }
}
