@extends('_master')

@section('title')
	Add a new book
@stop

@section('content')
	<h1>Add a new book</h1>

	{{ Form::open(array('url' => '/add')) }}

		{{ Form::text('title') }}

		{{ Form::submit() }}

	{{ Form::close() }}
@stop