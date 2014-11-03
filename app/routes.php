<?php

# /app/routes.php
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    } 
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});


Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Pre::render($results);

});



Route::get('/get-environment',function() {

    echo "Environment: ".App::environment();

});

// Homepage
Route::get('/', function() {
	
    return View::make('index');

});




// List all books / search
// function($format = 'html') defaults the view to html
Route::get('/list/{format?}', function($format = 'html') {
	
	//$query = $_GET['query']; //traditional php for next line of laravel-specific code
	$query = Input::get('query'); //this "get" not specific to GET method, willwork with POST

	$library = new Library();
	$library->setPath(app_path().'/database/books.json');
	$books = $library->getBooks();

	if($query) {
		$books = $library->search($query);
	}

    if ($format == 'json') {
        return 'JSON Version';
    }
    /* strtolower makes whatever is typed in URL by user lowercase because the URL is case sensitive */
    elseif (strtolower($format) == 'pdf') { 
        return 'PDF Version';
	}
	else {
		return View::make('list')
		->with('name', 'Joyce')
		->with('last_name', 'Smith')
		->with('books', $books)
		->with('query', $query);
		/* above shows how to use 'with' to pass information to the view. With creates a variable within view called 'name' that will be set to whatever second parameter is. Can pass string, object, array, integer--any data type. */
		 	
	}
});



// Display the form for a new book
Route::get('/add', function() {

    return View::make('add');

});

// Process form for a new book
Route::post('/add', function() {


});




// Display the form to edit a book
Route::get('/edit/{title}', function() {


});

// Process form for a edit book
Route::post('/edit/', function() {


});


// Test route to load and output books
Route::get('/data', function() {

	//Get the file
	//$books = File::get(app_path().'/database/books.json');

	// Convert to an array
	//$books = json_decode($books, true);

	$library = new Library();
	$library->setPath(app_path().'/database/books.json');
	$books = $library->getBooks();
	
	// Return the file
	echo Pre::render($books);
});


















