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

	public function showAllQuiz() {
		if ($this->quizView->getChosenQuiz() == false) {
			$this->htmlView->echoHTML($this->quizView->showAllQuiz());
		}
	}

	public function playQuiz() {
		if ($this->quizView->getChosenQuiz() == true) {
			if ($this->quizView->hasUserSubmitQuiz()) {
				$chosenQuiz = $this->quizView->getChosenQuiz();
				$userAnswers = $this->quizView->getUserAnswers();
				$score = $this->quizModel->validateQuiz($userAnswers, $chosenQuiz);
				$this->htmlView->echoHTML($this->quizView->showResult($score, $chosenQuiz));
			}
			else {
				$this->htmlView->echoHTML($this->quizView->showPlayQuiz($this->quizView->getChosenQuiz()));
			}
		}
	}
	
}