@extends('layout')

@section('content')

<a href="/milestones/{{ $repo }}">Show Milestones</a>

@if ($issues)

    <form method="post" action="/issues/add">
        {!! csrf_field() !!}

        @foreach ($issues as $issue)

            <li>
                <label>
                    {{ $issue['title'] }}
                    <input type="checkbox" name="issues[]" value="{{ $repo }}/{{ $issue['number'] }}">
                </label>
            </li>

        @endforeach

        <button type="submit">Save</button>
    </form>

@else

    No Issues

@endif

@endsection