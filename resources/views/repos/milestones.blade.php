@extends('layout')

@section('content')

<a href="/repos/{{ $repo }}">Show Issues</a>


@forelse ($milestones as $milestone)

    <li>{{ $milestone['title'] }}</li>

@empty

    No Milestones

@endforelse

@endsection