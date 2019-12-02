@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Books') }}</div>

                <div class="card-body">
                    <form action="{{ route('books') }}">
                        <div class="form-group row">
                            <label for="search" class="col-md-4 col-form-label text-md-right">{{ __('Title search') }}</label>

                            <div class="col-md-6">
                                <input id="search" type="search" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" required autocomplete="search" autofocus>

                                @error('search')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @isset($results)
                        <ul>
                            @foreach($results as $key => $entry)
                            <li><a href="{{ route('books.show', $key) }}">{{ $entry->title }}</a></li>
                            @endforeach
                        </ul>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
