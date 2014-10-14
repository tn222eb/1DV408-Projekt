<?php

class Question {

	private $answers;
	private $questionName;

	public function __construct() {
		$this->answers = array();
	}

	public function getName() {
		return $this->questionName;
	}

	public function toArray() {
		return $this->answers;
	}

	public function add(Answer $answer) {
		if ($this->contains($answer) == false) {
			$this->answers[] = $answer;
		}
	}

	public function contains(Answer $answer) {
		foreach($this->answers as $value) {
			if ($answer->equals($value)) {
				return true;
			}
		}	
		return false;
	}	
}