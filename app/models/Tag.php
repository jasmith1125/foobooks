

<?php

class Tag extends Eloquent {
	public function books() {
	# Tags belong to many Books
	return $this->belongsToMany('Book');
	}
}
