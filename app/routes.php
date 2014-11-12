<?php


//Using eloquent to read data from database, get one book
Route::get('/practice-reading-one-book', function() {

    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    if($book) {
        return $book->title;
    }
    else {
        return 'Book not found.';
    }

});

//Using eloquent to read data from database, chain constraints to choose select books
Route::get('/practice-reading-some-books', function() {

    $books = Book::where('author', 'LIKE', '%Scott%')
    ->orWhere('author', 'LIKE', '%Maya%')
    ->get();

    # Make sure we have results before trying to print them...
    if($books->isEmpty() != TRUE) {

        # Typically we'd pass $books to a View, but for quick and dirty demonstration, let's just output here...
        foreach($books as $book) {
            echo $book->title.'<br>';
        }
    }
    else {
        return 'No books found';
    }

});

//Using eloquent to read data from database, get all books
Route::get('/practice-reading', function() {

    # The all() method will fetch all the rows from a Model/table
    $books = Book::all();

    # Make sure we have results before trying to print them...
    if($books->isEmpty() != TRUE) {

        # Typically we'd pass $books to a View, but for quick and dirty demonstration, let's just output here...
        foreach($books as $book) {
            echo $book->title.'<br>';
        }
    }
    else {
        return 'No books found';
    }

});


Route::get('/practice-updating', function() {

    # First get a book to update
    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    # If we found the book, update it
    if($book) {

        # Give it a different title
        $book->title = 'The Really Great Gatsby';

        # Save the changes
        $book->save();

        return "Update complete; check the database to see if your update worked...";
    }
    else {
        return "Book not found, can't update.";
    }

});


// Deleting
Route::get('/practice-deleting', function() {

    # First get a book to delete
    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    # If we found the book, delete it
    if($book) {

        # Goodbye!
        $book->delete();

        return "Deletion complete; check the database to see if it worked...";

    }
    else {
        return "Can't delete - Book not found.";
    }

});


//Using eloquent to create--add new book
Route::get('/practice-create', function() {

    $book = new Book(); //Model, aka my ORM object (instantiate)

    $book->title = 'Cat in the Hat';
    $book->author = 'Dr. Seuss';
    $book->published = 1960;

    $book->save();

    return 'Your book has been added';
});

/* 
The best way to fill your tables with sample/test data is using Laravel's Seeding feature.
Before we get to that, though, here's a quick-and-dirty practice route that will
throw three books into the `books` table.
*/
Route::get('/seed', function() {
    # Build the raw SQL query
    $sql = "INSERT INTO books (author,title,published,cover,purchase_link) VALUES 
            ('F. Scott Fitzgerald','The Great Gatsby',1925,'http://img2.imagesbn.com/p/9780743273565_p0_v4_s114x166.JPG','http://www.barnesandnoble.com/w/the-great-gatsby-francis-scott-fitzgerald/1116668135?ean=9780743273565'),
            ('Sylvia Plath','The Bell Jar',1963,'http://img1.imagesbn.com/p/9780061148514_p0_v2_s114x166.JPG','http://www.barnesandnoble.com/w/bell-jar-sylvia-plath/1100550703?ean=9780061148514'),
            ('Maya Angelou','I Know Why the Caged Bird Sings',1969,'http://img1.imagesbn.com/p/9780345514400_p0_v1_s114x166.JPG','http://www.barnesandnoble.com/w/i-know-why-the-caged-bird-sings-maya-angelou/1100392955?ean=9780345514400')
            ";
    # Run the SQL query
    echo DB::statement($sql);
    # Get all the books just to test it worked
    $books = DB::table('books')->get();
    # Print all the books
    echo Paste\Pre::render($books,'');
});

/* example of database query, lecture 9 
Route::get('/test', function() {
# Returns and object of books
$books = DB::table('books')->get();

foreach ($books as $book) {
    echo $book->title."<br>";
    }
});*/

/* example of database query with where filter, lecture 9 
Route::get('/test2', function() {
    $books = DB::table('books')->where('author', 'LIKE', '%Scott%')->get();

foreach($books as $book) {
    echo $book->title;
}
});*/

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

	if($query) {
		$books = Book::where('author', 'LIKE', "%$query%")->
        orWhere('title', 'LIKE', "%$query%")->get();
	}
    else {
        $books = Book::all();
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
		->with('books', $books)
		->with('query', $query);
		/* above shows how to use 'with' to pass information to the view. With creates a variable within view called 'name' that will be set to whatever second parameter is. Can pass string, object, array, integer--any data type. */
		 	
	}
});

Route::get('/test', function() {

   
/*
   $author = new Author();
    $author->name = 'Sylvia Plath';
    $author->save();

    $book = new Book();
    $book->title = 'The Bell Jar';
    $book->author_id = $author->id; //connects foreign key to author
    $book->save(); 

    $author = new Author();
    $author->name = 'Maya Angelou';
    $author->save();

    $book = new Book();
    $book->title = 'I Know Why the Caged Bird Sings';
    $book->author_id = $author->id; //connects foreign key to author
    $book->save(); */

     # w/o eager loading: 7 Queries
    //$books = Book::with('author')->get();
    # w/ eager loading: 3 Queries
    #$books = Book::with('author')->with('tags')->get();

     $books = Book::with('author')->get();
    foreach($books as $book) {
        echo $book->title."<br>";
        echo $book->author->name;
        echo "<br><br>"; 
    } 
}); 




// Display the form for a new book
Route::get('/add', function() {

    return View::make('add');

});

// Process form for a new book, check that csrf token is present and valid
Route::post('/add', array('before'=>'csrf',
    function() {

    var_dump($_POST);

    $book = new Book();
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    $book->title = $_POST['title']; /* same as $book->title = Input::get('title'); */
 /* can pass multiple fields in array */
    $book->save();
    //can use a for loop to add multiple books

    return Redirect::to('/list');
}));




// Display the form to edit a book
Route::get('/edit/{title}', function($title) {
        
        return View::make('edit');

});

// Process form for a edit book
Route::post('/edit/', function() {
   # First get a book to update
    $book = Book::where('author', 'LIKE', '%query%')->first();
    # If we found the book, update it
    if($book) {
    # Give it a different title
    $book->title = $_POST['title'];
    # Save the changes
    $book->save();
    return "Update complete; check the database to see if your update worked...";
    }
    else {
    return "Book not found, can't update.";
    }

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


















