<?php

namespace App\Http\Controllers;

use App\Book;

class LibraryController extends Controller
{
    public function index()
    {
        return view('library.index');
    }

    public function store(Book $book)
    {
        auth()->user()->books()->syncWithoutDetaching([ $book->id ]);

        return redirect()->back()->with('info', sprintf('%s added to your library', $book->title));
    }

    public function delete(Book $book)
    {
        auth()->user()->books()->detach($book);

        return redirect()->back()->with('info', sprintf('%s has been removed from your library', $book->title));
    }
}
