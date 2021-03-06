<?php

require_once("View/PlayQuizView.php");
require_once("View/HTMLView.php");
require_once("Model/QuizModel.php");
require_once("View/QuizView.php");
require_once("Model/Quiz.php");
require_once("Model/Validation/ValidateInput.php");
require_once("Model/Dao/QuizRepository.php");
require_once("View/QuizMessage.php");
require_once("View/ResultView.php");
require_once("Model/Result.php");

class QuizController {

	private $playQuizView;
	private $htmlView;
	private $quizModel;
	private $quizView;
	private $quizMessage;
	private $cookieStorage;
	private $resultView;

	public function __construct() {
		$this->playQuizView = new PlayQuizView();
		$this->htmlView = new HTMLView();
		$this->quizModel = new QuizModel();
		$this->quizView = new QuizView();
		$this->quizRepository = new QuizRepository();
		$this->validateInput = new ValidateInput();
		$this->resultView = new ResultView();
	}

    /**
    * show user results
    */
	public function showMyResults($userId) {
		 $this->htmlView->echoHTML($this->resultView->showMyResults($userId)); 
	}

    /**
    * show all quizzes that you can play
    */
	public function showAllQuizToPlay() {
			$this->htmlView->echoHTML($this->playQuizView->showAllQuizToPlay());
	}

    /**
    * save edit of quiz
    */
	public function saveEditQuiz() {
		$currentQuiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$quizName = $this->quizView->getQuizName();
		if ($currentQuiz != null) {
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
						$this->quizMessage = new QuizMessage(9);
						$message = $this->quizMessage->getMessage();
						$this->quizView->saveMessage($message);					
					}
				}
			}
		}

		$this->quizView->redirectToShowAllQuiz();	
	}

    /**
    * renders confirm page for remove
    */
	public function confirmRemoveQuiz() {
		$quiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$this->htmlView->echoHTML($this->quizView->showConfirmToRemoveQuiz($quiz));
	}

    /**
    * remove quiz
    */	
	public function removeQuiz() {
		$quiz = $this->quizRepository->getQuiz($this->quizView->getId());
		$this->quizModel->removeQuiz($quiz);
		$this->quizMessage = new QuizMessage(1);
		$message = $this->quizMessage->getMessage();
		$this->quizView->saveMessage($message);
		$this->quizView->redirectToShowAllQuiz();	
	}

    /**
    * show all quiz
    */	
	public function showAllQuiz() {
		$this->htmlView->echoHTML($this->quizView->showAll($this->quizRepository->getQuizList()));
	}

    /**
    * show edit quiz form
    */	
	public function editQuiz(Quiz $quiz) {
		$this->htmlView->echoHTML($this->quizView->showEditQuizForm($quiz));
	}

    /**
    * validate if input is valid
    *
    * @param name of quiz
    *
    */
	public function validation($quizName) {
		if ($this->validateInput->validateLength($quizName) == false) {
				$this->quizMessage = new QuizMessage(10);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToShowCreateQuizForm();
				return false;
		}

		if ($this->validateInput->validateCharacters($quizName) == false) {
				$this->quizMessage = new QuizMessage(11);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				return false;
		}		

		return true;
	}

    /**
    * create a new quiz
    */
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
				$this->quizMessage = new QuizMessage(9);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToShowCreateQuizForm();
			}		
		}
		else {
			$this->htmlView->echoHTML($this->quizView->showCreateQuizForm());
		}
 	}


    /**
    * show a chosen quiz
    *
    * @param Object that contains a quiz
    *
    */
 	public function showQuiz(Quiz $quiz) {
 		 $this->htmlView->echoHTML($this->quizView->showQuiz($quiz));
 	}


    /**
    * play chosen quiz
    *
    * @param Id of quiz to play
    *
    */
	public function playQuiz($userId) {
		if ($this->playQuizView->hasUserSubmitQuiz()) {
			$chosenQuiz = $this->playQuizView->getChosenQuiz();
			$userAnswers = $this->playQuizView->getUserAnswers();
			$score = $this->quizModel->validateQuiz($userAnswers, $chosenQuiz);

			$quiz = $this->quizModel->getQuiz($chosenQuiz);
			$questions = $quiz->getQuestions();
			
			$quizResult = new Result($score, $this->quizModel->numOfQuestions($questions), $userId, $chosenQuiz);
			$this->quizModel->saveQuizResult($quizResult);
			$this->htmlView->echoHTML($this->playQuizView->showResult($score, $chosenQuiz));
		}
		else {
			$this->htmlView->echoHTML($this->playQuizView->showPlayQuiz($this->playQuizView->getChosenQuiz()));
		}
	}
	
}