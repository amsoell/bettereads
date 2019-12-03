<?php

namespace App;

use App\Http\Repositories\OpenLibrary as BookRepository;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn',
    ];

    public function resolveRouteBinding($value)
    {
        if ( ! $book_info = (new BookRepository())->getBook($value)) {
            abort(403);
        }

        $book = $this->where('isbn', $value)->firstOrCreate([
            'title' => $book_info->title,
            'isbn'  => $value,
        ]);

        $book->info = $book_info;

        return $book;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
