<?php

require_once("View/QuestionView.php");
require_once("View/HTMLView.php");
require_once("Model/Dao/QuizRepository.php");
require_once("Model/Dao/QuestionRepository.php");
require_once("Model/Question.php");
require_once("Model/QuestionModel.php");

class QuestionController {

	private $questionView;
	private $htmlView;
	private $quizRepository;
	private $questionRepository;

	public function __construct() {
		$this->questionView = new QuestionView();
		$this->htmlView = new HTMLView();
		$this->quizRepository = new QuizRepository();
		$this->questionModel = new QuestionModel();
		$this->questionRepository = new questionRepository();
	}

	public function addQuestion() {
		if ($this->questionView->didUserSubmitAddQuestion() == false) {
			$quiz = $this->quizRepository->getQuiz($this->questionView->getId());
			$this->htmlView->echoHTML($this->questionView->showAddQuestionForm($quiz));
		}
		else {
			$question = new Question ($this->questionView->getQuestionName(), $this->questionView->getId());
			$this->questionModel->addQuestion($question);
		}
	}

	public function showQuestion() {
		$question = $this->questionRepository->getQuestion($this->questionView->getId());
		$this->htmlView->echoHTML($this->questionView->showQuestion($question));
	}
	
}