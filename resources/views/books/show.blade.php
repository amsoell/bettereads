@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $book->title}}
                    @auth
                        @if (auth()->user()->books->pluck('isbn')->contains($book->isbn))
                        <form method="POST" action="{{ route('library.delete', $book->isbn) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary pull-right">Remove from library</button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('library.store', $book->isbn) }}">
                            @csrf
                            <button class="btn btn-primary pull-right">Add to library</button>
                        </form>
                        @endif
                    @endauth
                </div>

                <div class="card-body row">
                    @isset ($book->info->cover)
                    <div class="col-xs-12 col-md-4">
                        <img src="{{ $book->info->cover->medium }}" />
                    </div>
                    @endisset
                    <div class="col-xs-12 col-md-8">
                        @isset ($book->info->subtitle)
                        <h2>{{ $book->info->subtitle }}</h2>
                        @endisset
                        <dl>
                            @isset($book->info->authors)
                            <dt>{{ Str::plural('Author', count($book->info->authors)) }}</dt>
                            <dd>
                            @foreach ($book->info->authors as $author)
                                {{ $author->name }}
                                @unless ($loop->last)
                                <br />
                                @endunless
                            @endforeach
                            </dd>
                            @endisset
                            @isset($book->info->number_of_pages)
                            <dt>Pages:</dt>
                            <dd>{{ $book->info->number_of_pages }}</dd>
                            @endisset
                            <dt>Published:</dt>
                            <dd>{{ $book->info->publish_date }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
