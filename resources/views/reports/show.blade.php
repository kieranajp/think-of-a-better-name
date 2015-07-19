@extends('layout')

@section('content')

    @if ($report)

        @foreach ($report->issues as $issue)

            <li>#{{ $issue['number'] }} - {{ $issue['title'] }} ({{ $issue['state'] }})</li>

        @endforeach

        <form method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Wipe report</button>
        </form>

    @else

        <a href="/repos">Go add some issues</a>

    @endif

@endsection