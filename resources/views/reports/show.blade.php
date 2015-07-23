@extends('layout')

@section('content')

    @if ($report)

        @foreach ($report as $repo => $issues)

            <h4>{{ $repo }}</h4>

            <ul class="collection">
                @foreach ($issues as $issue)
                    <li class="collection-item">
                        #{{ $issue['number'] }} - {{ $issue['title'] }}


                        @foreach ($issue['labels'] as $label)
                            <span class="badge" style="color: #{{ $label['color'] }}">{{ $label['name'] }}</span>
                        @endforeach

                        <span class="badge">{{ $issue['state'] }}</span>

                    </li>
                @endforeach
            </ul>
        @endforeach


        <form method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Wipe report</button>
        </form>

    @else

        <a href="/repos">Go add some issues</a>

        <p>(If you've just added some, wait a few seconds and then refresh - I'm probably just fetching the details from Github)</p>

    @endif

@endsection