<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    //relation with user table 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relationship with comment table
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
