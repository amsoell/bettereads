<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request, GuzzleClient $guzzle)
    {
        if ($request->has('search')) {
            $response = $guzzle->get(sprintf('http://openlibrary.org/search.json?q=%s', urlencode($request->get('search'))));

            $results = json_decode($response->getBody());
        }

        return view('books.index', compact('results'));
    }
}
