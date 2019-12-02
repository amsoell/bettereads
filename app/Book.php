<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
