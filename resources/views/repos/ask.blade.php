@extends('layout')

@section('content')

<div class="row">

    <form method="post" class="col s12">
        {!! csrf_field() !!}

        <div class="row">

            <div class="input-field col s5 offset-s1">
                <input type="text" name="user">
            </div>

            <div class="input-field col s5">
                <input type="text" name="name">
            </div>

        </div>

        <div class="row">

            <div class="input-field col s3 offset-s7">

                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons">send</i>
                </button>

            </div>

        </div>
    </form>

</div>

@endsection