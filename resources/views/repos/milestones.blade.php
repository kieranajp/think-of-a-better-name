@extends('layout')

@section('content')

<a href="/repos/{{ $repo }}">Show issues</a>


@if ($milestones)

    <form class="col s12" method="post" action="/issues/add">
        {!! csrf_field() !!}

        @foreach ($milestones as $milestone)

            <li>
                <input type="checkbox" name="milestones[]" id="milestone-{{ $milestone['id'] }}" value="{{ $repo }}/{{ $milestone['number'] }}">
                <label for="milestone-{{ $milestone['id'] }}">
                    {{ $milestone['title'] }}
                </label>
            </li>

        @endforeach

        <button type="submit">Save</button>
    </form>

@else

    No milestones

@endif

@endsection