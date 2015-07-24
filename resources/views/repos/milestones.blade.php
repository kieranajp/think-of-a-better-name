@extends('layout')

@section('content')

<a href="/issues/{{ $repo }}">Show issues</a>


@if ($milestones)

    <form class="col s12" method="post" action="/issues/add">
        {!! csrf_field() !!}
        <ul class="collection">
            @foreach ($milestones as $milestone)

                <li class="collection-item">
                    <input type="checkbox" name="milestones[]" id="milestone-{{ $milestone['id'] }}" value="{{ $repo }}/{{ $milestone['number'] }}">
                    <label for="milestone-{{ $milestone['id'] }}">
                        {{ $milestone['title'] }}
                    </label>
                    <span class="badge">{{ $milestone['state'] }}</span>
                </li>

            @endforeach
        </ul>

        <button type="submit" class="btn waves-effect waves-light">Save</button>
    </form>

@else

    No milestones

@endif

@endsection