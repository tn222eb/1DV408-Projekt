<?php

require_once("Model/Validation/ValidateInput.php");
require_once("View/AnswerView.php");
require_once("Model/Dao/QuestionRepository.php");
require_once("View/HTMLView.php");
require_once("Model/Answers.php");
require_once("Model/AnswerModel.php");
require_once("View/QuizMessage.php");
require_once("View/BaseView.php");

class AnswerController {

	private $answerView;
	private $questionRepository;
	private $quizMessage;
	private $quizView;
	private $validateInput;
	private $CookieValueA = "CookieValueA";
	private $CookieValueB = "CookieValueB";
	private $CookieValueC = "CookieValueC";

	public function __construct() {
		$this->answerView = new AnswerView();
		$this->questionRepository = new QuestionRepository();
		$this->htmlView = new HTMLView();
		$this->answerModel = new AnswerModel();
		$this->quizView = new QuizView;
		$this->validateInput = new ValidateInput();
	}

	public function validate($string) {
		if ($this->validateInput->validateLength($string) == false) {
				$this->quizMessage = new QuizMessage(12);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->answerView->redirectToAddAnswers($this->answerView->getId());		
				return false;
		}

		if ($this->validateInput->validateCharacters($string) == false) {
				$this->quizMessage = new QuizMessage(13);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->answerView->redirectToAddAnswers($this->answerView->getId());	
				return false;
		}	

		return true;
	}

	public function rememberAnswers($answerA, $answerB, $answerC) {
		$this->quizView->saveValueMessage($this->CookieValueA, $answerA);
		$this->quizView->saveValueMessage($this->CookieValueB, $answerB);
		$this->quizView->saveValueMessage($this->CookieValueC, $answerC);
	}	

	public function addAnswers() {
		if ($this->answerView->hasSubmitAddAnswers() == false) {
			$question = $this->questionRepository->getQuestion($this->answerView->getId());
			$this->htmlView->echoHTML($this->answerView->showAddAnswersForm($question));			
		}
		else {
			$answerA = $this->answerView->getAnswerA();
			$answerB = $this->answerView->getAnswerB();
			$answerC = $this->answerView->getAnswerC();

			if ($this->validate($answerA) && $this->validate($answerB) && $this->validate($answerC)) {
				$checkedStatus = $this->answerView->getRightAnswerCheckBox();
				if (empty($checkedStatus)) {
					$this->quizMessage = new QuizMessage(11);
					$message = $this->quizMessage->getMessage();
					$this->quizView->saveMessage($message);
					$this->rememberAnswers($answerA, $answerB, $answerC);
					$this->answerView->redirectToAddAnswers($this->answerView->getId());	
				} 
				else {
					$answers = new Answers($answerA, $answerB, $answerC, $this->answerView->getRightAnswerCheckBox(), $this->answerView->getId());
					$this->answerModel->addAnswers($answers);
					$this->quizMessage = new QuizMessage(4);
					$message = $this->quizMessage->getMessage();
					$this->quizView->saveMessage($message);
					$question = $this->questionRepository->getQuestion($this->answerView->getId());
					$this->quizView->redirectToShowQuiz($question->getQuizId());	
				}
			}
			else {
				$this->rememberAnswers($answerA, $answerB, $answerC);
			}			
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