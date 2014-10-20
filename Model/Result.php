<?php

class Result {

	private $resultId;
	private $score;
	private $numOfQuestions;
	private $userId;
	private $quizId;

	public function __construct($score, $numOfQuestions, $userId, $quizId, $resultId = NULL) {
		$this->score = $score;
		$this->numOfQuestions = $numOfQuestions;
		$this->userId = $userId;
		$this->quizId = $quizId;
		$this->resultId = $resultId;
	}

	public function getResultId() {
		return $resultId;
	}

	public function getScore() {
		return $this->score;
	}

	public function getNumOfQuestions() {
		return $this->numOfQuestions;
	}

	public function getUserId() {
		return $this->userId;
	}
	
	public function getQuizId() {
		return $this->quizId;
	}
}