<?php

require_once("Model/Dao/QuestionRepository.php");
require_once("Model/Question.php");

class QuestionModel {

	private $questionRepository;

	public function __construct() {
		$this->questionRepository = new QuestionRepository();
	}

	public function addQuestion(Question $question) {
		$this->questionRepository->addQuestion($question);
	}
}