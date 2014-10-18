<?php

require_once("View/PlayQuizView.php");
require_once("View/HTMLView.php");
require_once("Model/QuizModel.php");
require_once("View/QuizView.php");
require_once("Model/Quiz.php");
require_once("Model/Dao/QuizRepository.php");

class QuizController {

	private $playQuizView;
	private $htmlView;
	private $quizModel;
	private $quizView;

	public function __construct() {
		$this->playQuizView = new PlayQuizView();
		$this->htmlView = new HTMLView();
		$this->quizModel = new QuizModel();
		$this->quizView = new QuizView();
		$this->quizRepository = new QuizRepository();
	}

	public function showAllQuizToPlay() {
			$this->htmlView->echoHTML($this->playQuizView->showAllQuizToPlay());
	}

	public function saveEditQuiz() {
		$quiz = new Quiz($this->quizView->getQuizName(), $this->quizView->getId());
		$this->quizModel->saveEditQuiz($quiz);
	}

	public function confirmRemoveQuiz() {
		$quiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$this->htmlView->echoHTML($this->quizView->showConfirmToRemoveQuiz($quiz));
	}

	public function removeQuiz() {
		$quiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$this->quizModel->removeQuiz($quiz);
	}

	public function showAllQuiz() {
		$this->htmlView->echoHTML($this->quizView->showAll($this->quizRepository->getQuizList()));
	}

	public function editQuiz(Quiz $quiz) {
		$this->htmlView->echoHTML($this->quizView->showEditQuizForm($quiz));
	}

	public function createQuiz() {
		if ($this->quizView->didUserPressToSubmitCreateQuiz()) {
			$quiz = new Quiz($this->quizView->getQuizName());
			$this->quizModel->addQuiz($quiz);
		}
		else {
			$this->htmlView->echoHTML($this->quizView->showCreateQuizForm());
		}
 	}

 	public function showQuiz(Quiz $quiz) {
 		 $this->htmlView->echoHTML($this->quizView->showQuiz($quiz));
 	}

	public function playQuiz($userId) {
			if ($this->playQuizView->hasUserSubmitQuiz()) {
				$chosenQuiz = $this->playQuizView->getChosenQuiz();
				$userAnswers = $this->playQuizView->getUserAnswers();
				$score = $this->quizModel->validateQuiz($userAnswers, $chosenQuiz);

				$quiz = $this->quizModel->getQuiz($chosenQuiz);
				$questions = $quiz->getQuestions();

				$this->quizModel->saveQuizResult($score, count($questions->toArray()), $chosenQuiz, $userId);
				$this->htmlView->echoHTML($this->playQuizView->showResult($score, $chosenQuiz));
			}
			else {
				$this->htmlView->echoHTML($this->playQuizView->showPlayQuiz($this->playQuizView->getChosenQuiz()));
			}
	}
	
}