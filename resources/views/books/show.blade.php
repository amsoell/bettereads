@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $book->title}}</div>

                <div class="card-body row">
                    @isset ($book->cover)
                    <div class="col-xs-12 col-md-4">
                        <img src="{{ $book->cover->medium }}" />
                    </div>
                    @endisset
                    <div class="col-xs-12 col-md-8">
                        @isset ($book->subtitle)
                        <h2>{{ $book->subtitle }}</h2>
                        @endisset
                        <dl>
                            @isset($book->authors)
                            <dt>{{ Str::plural('Author', count($book->authors)) }}</dt>
                            <dd>
                            @foreach ($book->authors as $author)
                                {{ $author->name }}
                                @unless ($loop->last)
                                <br />
                                @endunless
                            @endforeach
                            </dd>
                            @endisset
                            @isset($book->number_of_pages)
                            <dt>Pages:</dt>
                            <dd>{{ $book->number_of_pages }}</dd>
                            @endisset
                            <dt>Published:</dt>
                            <dd>{{ $book->publish_date }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
