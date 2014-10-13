<?php


# Homepage
Route::get('/', function() {

	return View::make('index');


});


// List all books / search
Route::get('/list/{query?}', function($query) {

	return View::make('list');
});

//Display the form for a new book
Route::get('/add', function() {
	
	
});

//process the form for a new book
Route::post('/add', function() {
	
	
});

//Display the form to edit a book
Route::get('/edit/{title}', function($title = 'Green Eggs and Ham') {
	
	
});

//process the form to edit a book
Route::post('/edit', function() {
	
	
});



Route::get('/data', function() {

	// Get the file
	$books = File::get(app_path().'/database/books.json');

	// Convert to an array
	$books = json_decode($books,true);

	//return the file
	echo Pre::render($books);
});




