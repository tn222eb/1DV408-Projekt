<?php

require_once("View/QuizView.php");
require_once("View/HTMLView.php");
require_once("Model/QuizModel.php");

class QuizController {

	public function __construct() {
		$this->quizView = new QuizView();
		$this->htmlView = new HTMLView();
		$this->quizModel = new QuizModel();
	}

	public function playQuiz() {
		if ($this->quizView->hasUserSubmitQuiz()) {
			$userAnswers = $this->quizView->getUserAnswers();
			$score = $this->quizModel->validateQuiz($userAnswers);
			$this->htmlView->echoHTML($this->quizView->showScore($score));
		}
		else {
			$this->htmlView->echoHTML($this->quizView->showQuiz());
		}
	}
	
}