@extends('_master')

@section('title')
	Edit a book you have added
@stop

@section('content')
	<h1>Edit a book</h1>

	{{ Form::open(array('url' => '/edit')) }}

		{{ Form::text('title') }}

		{{ Form::submit() }}

	{{ Form::close() }}

@stop
