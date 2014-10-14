<?php

class QuizList {
	private $quizzes;

	public function __construct() {
		$this->quizzes = array();
	}
	public function toArray() {
		return $this->quizzes;
	}

	public function add(Quiz $quiz) {
		if ($this->contains($quiz) == false) {
			$this->quizzes[] = $quiz;
		}
	}

	public function contains(Quiz $quiz) {
		foreach($this->quizzes as $value) {
			if ($quiz->equals($value)) {
				return true;
			}
		}	
		return false;
	}		
}