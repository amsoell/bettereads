@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Book') }}</div>

                <div class="card-body">
                    <h1>{{ $book->title}}</h1>
                    @isset ($book->subtitle)
                    <h2>{{ $book->subtitle }}</h2>
                    @endisset
                    <img src="{{ $book->cover->medium }}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
