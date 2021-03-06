<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public $timestamps = false; 

    public function comments()
    {
      return $this->belongsToMany(Comment::class);
    }
    public function tags()
    {
      return $this->belongsToMany(Tag::class);
    }

}
