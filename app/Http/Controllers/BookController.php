<?php

namespace App\Http\Controllers;

use App\Http\Repositories\OpenLibrary as BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $results = BookRepository::find($request->get('search'));
        }

        return view('books.index', compact('results'));
    }
}
