<?php

require_once("Model/Questions.php");

class Quiz {
	private $quizName;
	private $quizId;
	private $questions;

	public function __construct($quizName, $quizId = NULL) {
		$this->quizName = $quizName;
		$this->questions = new Questions();

		if (empty($quizId) == false) {
			$this->quizId = $quizId;
		}
	}

	public function getQuizId() {
		return $this->quizId;
	}

	public function getName() {
		return $this->quizName;
	}

	public function add(Question $question) {
		$this->questions->add($question);
	}

	public function getQuestions() {
		return $this->questions;
	}

	public function equals(Quiz $other) {
		return $this->getName() == $other->getName() && $this->getUnique() == $other->getUnique();
	}
}