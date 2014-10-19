<?php

require_once("Model/Answers.php");
require_once("Model/Dao/AnswerRepository.php");

class AnswerModel {
	
	private $answerRepository;
	private $sessionMessages = array();

	public function __construct() {
		$this->answerRepository = new AnswerRepository();
	}

	public function addAnswers(Answers $answers) {
		$this->answerRepository->addAnswers($answers);
	}
}