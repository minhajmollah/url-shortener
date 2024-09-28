@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">Welcome to the URL Shortener</h1>

                @auth
                    <form action="{{ route('urls.store') }}" method="POST" class="form-inline justify-content-center">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="original_url" class="sr-only">Enter URL to Shorten:</label>
                            <input type="url" name="original_url" id="original_url" class="form-control"
                                placeholder="Enter URL here" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3 ml-2">Shorten URL</button>
                    </form>

                    @if (session('short_url'))
                        <div class="alert alert-success mt-3">
                            <p>Short URL:
                                <a href="{{ session('short_url') }}" target="_blank">{{ session('short_url') }}</a>
                            </p>
                        </div>
                    @endif
                @else
                    <p>Please <a href="{{ route('login') }}">login</a> to shorten a URL.</p>
                @endauth
            </div>
        </div>
    </div>
@endsection
