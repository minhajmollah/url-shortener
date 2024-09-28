@extends('layouts.master')

@section('title', 'Statistics')

@section('content')
    <h1> URL Statistics</h1>

    @if ($urls->isEmpty())
        <p>You have not shortened any URLs yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Original URL</th>
                    <th>Shortened URL</th>
                    <th>Click Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urls as $url)
                    <tr>
                        <td>{{ $url->original_url }}</td>
                        <td><a href="{{ url('r/' . $url->short_code) }}"
                                target="_blank">{{ url('r/' . $url->short_code) }}</a></td>
                        <td>{{ $url->click_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
