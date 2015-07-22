@extends('layout')

@section('content')

<a href="/milestones/{{ $repo }}">Show Milestones</a>

@if ($issues)

    <form class="col s12" method="post" action="/issues/add">
        {!! csrf_field() !!}

        @foreach ($issues as $issue)

            <li>
                <input type="checkbox" name="issues[]" id="issue-{{ $issue['id'] }}" value="{{ $repo }}/{{ $issue['number'] }}">
                <label for="issue-{{ $issue['id'] }}">
                    {{ $issue['title'] }}
                </label>
            </li>

        @endforeach

        <button type="submit">Save</button>
    </form>

@else

    No Issues

@endif

@endsection