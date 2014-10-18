<?php

require_once("View/QuestionView.php");
require_once("View/HTMLView.php");
require_once("Model/Dao/QuizRepository.php");
require_once("Model/Dao/QuestionRepository.php");
require_once("Model/Question.php");
require_once("Model/QuestionModel.php");
require_once("View/QuizMessage.php");
require_once("Model/Validation/ValidateInput.php");

class QuestionController {

	private $questionView;
	private $htmlView;
	private $quizRepository;
	private $questionRepository;
	private $quizMessage;
	private $quizView;
	private $validateInput;

	public function __construct() {
		$this->questionView = new QuestionView();
		$this->htmlView = new HTMLView();
		$this->quizRepository = new QuizRepository();
		$this->questionModel = new QuestionModel();
		$this->questionRepository = new questionRepository();
		$this->quizView = new QuizView();
		$this->validateInput = new ValidateInput();
	}

	public function validate($questionName) {
		if ($this->validateInput->validateLength($questionName) == false) {
				$this->quizMessage = new QuizMessage(8);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToAddQuestion($this->quizView->getId());
				return false;
		}

		if ($this->validateInput->validateCharacters($questionName) == false) {
				$this->quizMessage = new QuizMessage(9);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToAddQuestion($this->quizView->getId());		
				return false;
		}

		if ($this->questionRepository->questionExists($questionName)) {
				$this->quizMessage = new QuizMessage(10);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToAddQuestion($this->quizView->getId());		
				return false;			
		}		

		return true;
	}	

	public function addQuestion() {
		if ($this->questionView->didUserSubmitAddQuestion() == false) {
				$quiz = $this->quizRepository->getQuiz($this->questionView->getId());
				$this->htmlView->echoHTML($this->questionView->showAddQuestionForm($quiz));
		}
		else {
			$questionName = $this->questionView->getQuestionName();
			if ($this->validate($questionName)) {
				$question = new Question ($questionName, $this->questionView->getId());
				$this->questionModel->addQuestion($question);
				$this->quizMessage = new QuizMessage(3);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToShowQuiz($this->quizView->getId());	
			}			
		}
	}

	public function showQuestion() {
		$question = $this->questionRepository->getQuestion($this->questionView->getId());
		$this->htmlView->echoHTML($this->questionView->showQuestion($question));
	}
	
}