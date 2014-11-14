<?php

class DebugController extends BaseController {


	/**
	* http://localhost/debug/index
	*
	* @return String
	*/
	public function getIndex() {

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

	}


	/**
	* Trigger an error to test debug display settings
	* http://localhost/debug/trigger-error
	*
	* @return Exception
	*/
	public function getTriggerError() {

		# Class Foobar should not exist, so this should create an error
		$foo = new Foobar;

	}


	/**
	* Print all available routes
	* http://localhost/debug/routes
	*
	* @return String
	*/
	public function getRoutes() {

		$routeCollection = Route::getRoutes();

		foreach ($routeCollection as $value) {
	    	echo "<a href='/".$value->getPath()."' target='_blank'>".$value->getPath()."</a><br>";
		}

	}


	/**
	* http://localhost/debug/books-json
	*
	* @return String
	*/
	public function getBooksJson() {

		# Instantiating an object of the Library class
		$library = new Library(app_path().'/database/books.json');

		# Get the books
		$books = $library->get_books();

		# Debug
		return Pre::render($books, 'Books');
	}


	/**
	* Old seeder - have since moved to proper seeding
	* http://localhost/debug/books-json
	*
	* @return String
	*/
	public function seedBooks() {

		return 'This seed will no longer work because the books table is no longer embedded with the author.';

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

	}

	/*
	* Test to make sure we can connect to MySQL
	*
	* @return String
	*/
	public function mysqlTest() {

	    # Print environment
	    echo 'Environment: '.App::environment().'<br>';

	    # Use the DB component to select all the databases
	    $results = DB::select('SHOW DATABASES;');

	    # If the "Pre" package is not installed, you should output using print_r instead
	    echo Pre::render($results);

	}


}