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
		$this->quizzes[] = $quiz;
	}

}