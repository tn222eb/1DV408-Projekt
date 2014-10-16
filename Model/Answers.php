<?php

class Answers {

	private $questionId;
	private $answerId;
	private $rightAnswer;
	private $answers = array();

	public function __construct($answerA, $answerB, $answerC , $rightAnswer, $questionId, $answerId = NULL) {
		$this->answers[] = $answerA;
		$this->answers[] = $answerB;		
	    $this->answers[] = $answerC;
	    $this->rightAnswer = $rightAnswer;		

		$this->questionId = $questionId;

	 	if (empty($answerId) == false) {
	 		$this->answerId = $answerId;
	 	}
	}

	public function getAnswers() {
		return $this->answers;
	}

	public function getRightAnswer() {
		return $this->rightAnswer;
	}

	public function getAnswer($i) {
		return $this->answers[$i];
	}

	public function getAnswerId() {
		return $this->answerId;
	}

	public function getQuestionId() {
		return $this->questionId;
	}
	
}