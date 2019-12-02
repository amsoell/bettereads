<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Repositories\OpenLibrary as BookRepository;

class LibraryController extends Controller
{
    public function store(string $isbn, BookRepository $book_repository)
    {
        $book = Book::where('isbn', $isbn)->firstOr(function () use ($book_repository, $isbn) {
            if ( ! $book = $book_repository->getBook($isbn)) {
                abort(403);
            }

            return Book::create([
                'title' => $book->title,
                'isbn'  => $isbn,
            ]);
        });

        if (auth()->user()->books->contains($book)) {
            return redirect()->back()->with('error', 'This book is already in your library');
        }

        auth()->user()->books()->attach($book);

        return redirect()->back()->with('info', sprintf('%s added to your library', $book->title));
    }

    public function delete(string $isbn)
    {
        $book = Book::where('isbn', $isbn)->firstOrFail();

        auth()->user()->books()->detach($book);

        return redirect()->back()->with('info', sprintf('%s has been removed from your library', $book->title));
    }
}
