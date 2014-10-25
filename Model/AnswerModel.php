<?php

require_once("Model/Answers.php");
require_once("Model/Dao/AnswerRepository.php");

class AnswerModel {
	
	private $answerRepository;

	public function __construct() {
		$this->answerRepository = new AnswerRepository();
	}

	public function addAnswers(Answers $answers) {
		$this->answerRepository->addAnswers($answers);
	}

	public function removeAnswers(Answers $answers) {
		$this->answerRepository->removeAnswers($answers);
	}
}