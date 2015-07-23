@extends('layout')

@section('content')

<a href="/milestones/{{ $repo }}">Show Milestones</a>

@if ($issues)

    <form class="col s12" method="post" action="/issues/add">
        {!! csrf_field() !!}

        <ul class="collection">

        @foreach ($issues as $issue)

            <li class="collection-item">
                <input type="checkbox" name="issues[]" id="issue-{{ $issue['id'] }}" value="{{ $repo }}/{{ $issue['number'] }}">
                <label for="issue-{{ $issue['id'] }}">
                    {{ $issue['title'] }}
                </label>

                <div class="statuses" style="overflow:auto">
                    @foreach ($issue['labels'] as $label)
                        <span class="badge" style="color: #{{ $label['color'] }}">{{ $label['name'] }}</span>
                    @endforeach

                    <span class="badge">{{ $issue['state'] }}</span>
                </div>
            </li>

        @endforeach

        </ul>

        <button type="submit">Save</button>
    </form>

@else

    No Issues

@endif

@endsection