<!-- /app/views/signup.blade.php -->
@extends('_master')

@section('title')
	Sign Up for Foobooks
@stop

@section('head')
	
@stop

@section('content')

<h1>Sign up</h1>

{{ Form::open(array('url' => '/signup')) }}

    Email<br>
    {{ Form::text('email') }}<br><br>

    Password:<br>
    {{ Form::password('password') }}<br><br>

    {{ Form::submit('Submit') }}

{{ Form::close() }}

@stop