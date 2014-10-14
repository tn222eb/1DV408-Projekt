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
		if ($this->contains($question) == false) {
			$this->questions[] = $question;
		}
	}

	public function contains(Question $question) {
		foreach($this->questions as $value) {
			if ($question->equals($value)) {
				return true;
			}
		}	
		return false;
	}	

}