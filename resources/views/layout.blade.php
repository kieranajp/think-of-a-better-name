<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo"><i class="material-icons">local_bar</i></a>
            <ul class="right hide-on-med-and-down">
            @if (Auth::check())

                <li><a href="/repos"><i class="material-icons left">note_add</i>Add Issues</a></li>
                <li><a href="/report"><i class="material-icons left">assignment</i>Show Report</a></li>

            @else

                <li><a href="/auth/github"><i class="material-icons right">lock</i>Sign in with GitHub</a></li>

            @endif
            </ul>
        </div>
    </nav>





    <div class="container">

        @yield('content')

    </div>
</body>
</html>
