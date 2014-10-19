<?php

require_once("View/PlayQuizView.php");
require_once("View/HTMLView.php");
require_once("Model/QuizModel.php");
require_once("View/QuizView.php");
require_once("Model/Quiz.php");
require_once("Model/Validation/ValidateInput.php");
require_once("Model/Dao/QuizRepository.php");
require_once("View/QuizMessage.php");

class QuizController {

	private $playQuizView;
	private $htmlView;
	private $quizModel;
	private $quizView;
	private $quizMessage;
	private $cookieStorage;

	public function __construct() {
		$this->playQuizView = new PlayQuizView();
		$this->htmlView = new HTMLView();
		$this->quizModel = new QuizModel();
		$this->quizView = new QuizView();
		$this->quizRepository = new QuizRepository();
		$this->validateInput = new ValidateInput();
	}

	public function showAllQuizToPlay() {
			$this->htmlView->echoHTML($this->playQuizView->showAllQuizToPlay());
	}

	public function saveEditQuiz() {
		$currentQuiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$quizName = $this->quizView->getQuizName();
		if ($currentQuiz->getName() != $quizName) {
			if ($this->validation($quizName)) {
				if ($this->quizRepository->quizExists($quizName) == false) {
					$editQuiz = new Quiz($quizName, $this->quizView->getId());
					$this->quizModel->saveEditQuiz($editQuiz);
					$this->quizMessage = new QuizMessage(2);
					$message = $this->quizMessage->getMessage();
					$this->quizView->saveMessage($message);
				}
				else {
					$this->quizMessage = new QuizMessage(5);
					$message = $this->quizMessage->getMessage();
					$this->quizView->saveMessage($message);					
				}
			}
		}

		$this->quizView->redirectToShowAllQuiz();	
	}

	public function confirmRemoveQuiz() {
		$quiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$this->htmlView->echoHTML($this->quizView->showConfirmToRemoveQuiz($quiz));
	}

	public function removeQuiz() {
		$quiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$this->quizModel->removeQuiz($quiz);
		$this->quizMessage = new QuizMessage(1);
		$message = $this->quizMessage->getMessage();
		$this->quizView->saveMessage($message);
		$this->quizView->redirectToShowAllQuiz();	
	}

	public function showAllQuiz() {
		$this->htmlView->echoHTML($this->quizView->showAll($this->quizRepository->getQuizList()));
	}

	public function editQuiz(Quiz $quiz) {
		$this->htmlView->echoHTML($this->quizView->showEditQuizForm($quiz));
	}

	public function validation($quizName) {
		if ($this->validateInput->validateLength($quizName) == false) {
				$this->quizMessage = new QuizMessage(6);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToShowCreateQuizForm();
				return false;
		}

		if ($this->validateInput->validateCharacters($quizName) == false) {
				$this->quizMessage = new QuizMessage(7);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				return false;
		}		

		return true;
	}

	public function createQuiz() {
		if ($this->quizView->didUserPressToSubmitCreateQuiz()) {
			$quizName = $this->quizView->getQuizName();

			if ($this->quizModel->quizExists($quizName) == false) {
				if ($this->validation($quizName)) {
					$quiz = new Quiz($quizName);
					$this->quizModel->addQuiz($quiz);

					$this->quizMessage = new QuizMessage(0);
					$message = $this->quizMessage->getMessage();
					$this->quizView->saveMessage($message);
					$this->quizView->redirectToShowAllQuiz();
				}
				else {
					$this->quizView->redirectToShowCreateQuizForm();
				}
			}
			else {
				$this->quizMessage = new QuizMessage(5);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToShowCreateQuizForm();
			}		
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