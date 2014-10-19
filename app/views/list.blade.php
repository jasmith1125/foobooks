@extends('_master')

@section('title')
	Books
@stop

@section('content')
	<h1>Books</h1>
	Hello, {{ $name.' '.$last_name }}<!-- blade syntax, same as <?php echo $name. ' ' .$last_name; ?> -->.

	

		View as:
		<a href='/list/json' target='_blank'>JSON</a> | 
		<a href='/list/pdf' target='_blank'>PDF</a>
	
	@foreach($books as $title => $book)<!-- blade syntax-->
		<sectin>
		<h2>{{ $title }}</h2>
		</section>
	@endforeach

	<!-- 3 curly brackets converts any special characters into harmless html. Always use when you are outputting info. the user has input. protects from xxs or cross-site scripting. user tries to force scripting into site to mess up form -->
	<h2>You searched for {{{ $query }}}</h2>


@stop






