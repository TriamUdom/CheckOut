@extends('templates.master')

@section('content')
    HI {{ Session::get('username') }}
    @include('components.logout_button')
@stop
