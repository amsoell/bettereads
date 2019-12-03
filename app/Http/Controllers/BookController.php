<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Repositories\OpenLibrary as BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request, BookRepository $book_repository)
    {
        if ($request->filled('search')) {
            $results = $book_repository->find($request->get('search'));
        }

        return view('books.index', compact('results'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
