<?php

class Question {

	private $answers;
	private $questionName;
	private $questionId;
	private $quizId;

	public function __construct($questionName, $quizId, $questionId = NULL) {
		$this->questionName = $questionName;
		$this->quizId = $quizId;
		
		if (empty($questionId) == false) {
			$this->questionId = $questionId;
		}

		$this->answers = array();
	}

	public function getName() {
		return $this->questionName;
	}

	public function getQuizId() {
		return $this->quizId;
	}

	public function getQuestionId() {
		return $this->questionId;
	}

	public function toArray() {
		return $this->answers;
	}

	public function add(Answers $answer) {
			$this->answers[] = $answer;
	}
}