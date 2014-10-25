<?php

require_once("Model/Dao/QuestionRepository.php");
require_once("Model/Question.php");

class QuestionModel {

	private $questionRepository;

	public function __construct() {
		$this->questionRepository = new QuestionRepository();
	}

	public function removeQuestion(Question $question) {
		$this->questionRepository->removeQuestion($question);
	}

	public function saveEditQuestion(Question $question) {
		$this->questionRepository->saveEditQuestion($question);
	}	

	public function addQuestion(Question $question) {
		$this->questionRepository->addQuestion($question);
	}

	public function getQuestion($questionId) {
		return $this->questionRepository->getQuestion($questionId);
	}
}