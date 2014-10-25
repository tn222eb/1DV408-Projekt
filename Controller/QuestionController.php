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

    /**
     * validate if input is valid
     */
	public function validate($questionName) {
		if ($this->validateInput->validateLength($questionName) == false) {
				$this->quizMessage = new QuizMessage(12);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToAddQuestion($this->quizView->getId());
				return false;
		}

		if ($this->validateInput->validateCharacters($questionName) == false) {
				$this->quizMessage = new QuizMessage(13);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToAddQuestion($this->quizView->getId());		
				return false;
		}

		if ($this->questionRepository->questionExists($questionName)) {
				$this->quizMessage = new QuizMessage(14);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToAddQuestion($this->quizView->getId());		
				return false;			
		}		

		return true;
	}	


    /**
    * renders confirm page for remove
    */
	public function confirmRemoveQuestion() {
		$question = $this->questionRepository->getQuestion($this->questionView->getId());
		$this->htmlView->echoHTML($this->questionView->showConfirmToRemoveQuestion($question));
	}

    /**
    * remove question
    */	
	public function removeQuestion() {
		$question = $this->questionRepository->getQuestion($this->questionView->getId());
		$this->questionModel->removeQuestion($question);
		$this->quizMessage = new QuizMessage(3);
		$message = $this->quizMessage->getMessage();
		$this->quizView->saveMessage($message);
		$this->quizView->redirectToShowQuiz($question->getQuizId());		
	}		

    /**
    * show edit question form
    */	
	public function editQuestion(Question $question) {
		$this->htmlView->echoHTML($this->questionView->showEditQuestionForm($question));
	}

    /**
    * save edit of question
    */
	public function saveEditQuestion() {
		$currentQuestion = $this->questionRepository->getQuestion($this->questionView->getId());
		$questionName = $this->questionView->getQuestionName();
		if ($currentQuestion != null) {
			if ($currentQuestion->getName() != $questionName) {
				if ($this->validate($questionName)) {
					if ($this->questionRepository->questionExists($questionName) == false) {
						$editQuestion = new Question($questionName, $currentQuestion->getQuizId(), $this->questionView->getId());
						$this->questionModel->saveEditQuestion($editQuestion);
						$this->quizMessage = new QuizMessage(4);
						$message = $this->quizMessage->getMessage();
						$this->quizView->saveMessage($message);
					}
					else {
						$this->quizMessage = new QuizMessage(14);
						$message = $this->quizMessage->getMessage();
						$this->quizView->saveMessage($message);					
					}
				}
			}
		}

		$this->quizView->redirectToShowQuiz($currentQuestion->getQuizId());	
	}

    /**
     * add a question to quiz
     */
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
				$this->quizMessage = new QuizMessage(5);
				$message = $this->quizMessage->getMessage();
				$this->quizView->saveMessage($message);
				$this->quizView->redirectToShowQuiz($this->quizView->getId());	
			}			
		}
	}
	
    /**
     * show a chosen question
     */
	public function showQuestion() {
		$question = $this->questionRepository->getQuestion($this->questionView->getId());
		$this->htmlView->echoHTML($this->questionView->showQuestion($question));
	}
	
}