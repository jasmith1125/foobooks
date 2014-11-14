<?php

class BookController extends \BaseController {


	/**
	*
	*/
	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();

		# Only logged in users should have access to this controller
		$this->beforeFilter('auth');

	}


	/**
	* Process the searchform
	* @return View
	*/
	public function getSearch() {

		return View::make('book_search');

	}


	/**
	* Display all books
	* @return View
	*/
	public function getIndex() {

		# Format and Query are passed as Query Strings
		$format = Input::get('format', 'html');

		$query  = Input::get('query');

		$books = Book::search($query);

		# Decide on output method...
		# Default - HTML
		if($format == 'html') {
			return View::make('book')
				->with('books', $books)
				->with('query', $query);
		}
		# JSON
		elseif($format == 'json') {
			return Response::json($books);
		}
		# PDF (Coming soon)
		elseif($format == 'pdf') {
			return "This is the pdf (Coming soon).";
		}


	}


	/**
	* Show the "Add a book form"
	* @return View
	*/
	public function getCreate() {

		$authors = Author::getIdNamePair();

    	return View::make('add')->with('authors',$authors);

	}


	/**
	* Process the "Add a book form"
	* @return Redirect
	*/
	public function postCreate() {

		# Instantiate the book model
		$book = new Book();

		$book->fill(Input::all());
		$book->save();

		# Magic: Eloquent
		$book->save();

		return Redirect::action('BookController@getIndex')->with('flash_message','Your book has been added.');

	}


	/**
	* Show the "Edit a book form"
	* @return View
	*/
	public function getEdit($id) {

		try {
		    $book    = Book::findOrFail($id);
		    $authors = Author::getIdNamePair();
		}
		catch(exception $e) {
		    return Redirect::to('/list')->with('flash_message', 'Book not found');
		}

    	return View::make('edit')
    		->with('book', $book)
    		->with('authors', $authors);

	}

	/**
	* Process the "Edit a book form"
	* @return Redirect
	*/
	public function postEdit() {

		try {
	        $book = Book::findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/list')->with('flash_message', 'Book not found');
	    }

	    # http://laravel.com/docs/4.2/eloquent#mass-assignment
	    $book->fill(Input::all());
	    $book->save();

	   	return Redirect::action('BookController@getIndex')->with('flash_message','Your changes have been saved.');

	}



}