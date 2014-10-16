	<?php

class Questions {
	private $questions;

	public function __construct() {
		$this->questions = array();
	}
	public function toArray() {
		return $this->questions;
	}

	public function add(Question $question) {
			$this->questions[] = $question;
	}
}