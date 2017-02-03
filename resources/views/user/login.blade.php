@extends('templates.master')

@section('content')
    <h5>Login</h5><br />
    <form action="/login" method="POST">
        <input type="text" name="username" placeholder="Username"><br />
        <input type="password" name="password" placeholder="Password"><br />
        {{ csrf_field() }}
        <input type="submit" value="Login">
    </form>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@stop
