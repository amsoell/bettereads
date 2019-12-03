@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.info-and-errors')
            <div class="card">
                <div class="card-header">{{ __('My Library') }}</div>

                <div class="card-body">
                    <ul>
                        @forelse (auth()->user()->books->sortByDesc('pivot.created_at') as $book)
                            <li><a href="{{ route('books.show', $book->isbn) }}">{{ $book->title }}</a> &mdash; Added {{ $book->pivot->created_at->diffForHumans() }}</li>
                        @empty
                        <p>Your library is empty. Go <a href="{{ route('books') }}">search for some great books</a>.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
