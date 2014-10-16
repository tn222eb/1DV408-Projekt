<?php

require_once("View/AnswerView.php");
require_once("Model/Dao/QuestionRepository.php");
require_once("View/HTMLView.php");
require_once("Model/Answers.php");
require_once("Model/AnswerModel.php");

class AnswerController {

	private $answerView;
	private $questionRepository;

	public function __construct() {
		$this->answerView = new AnswerView();
		$this->questionRepository = new QuestionRepository();
		$this->htmlView = new HTMLView();
		$this->answerModel = new AnswerModel();
	}

	public function addAnswers() {
		if ($this->answerView->hasSubmitAddAnswers() == false) {
			$question = $this->questionRepository->getQuestion($this->answerView->getId());
			$this->htmlView->echoHTML($this->answerView->showAddAnswersForm($question));			
		}
		else {
			$answers = new Answers($this->answerView->getAnswerA(), $this->answerView->getAnswerB(), $this->answerView->getAnswerC(), $this->answerView->getRightAnswerCheckBox() ,$this->answerView->getId());
			$this->answerModel->addAnswers($answers);
		}
	}

	public function hasNoAnswers() {
		$question = $this->questionRepository->getQuestion($this->answerView->getId());
		if (count($question->toArray()) > 0) {
			return false;
		}
		return true;
	}
}