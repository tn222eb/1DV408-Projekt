<?php

require_once("View/QuizView.php");
require_once("helper/CookieStorage.php");

class AnswerView {

	public function __construct() {
		$this->quizView = new QuizView();
		$this->cookieStorage = new CookieStorage();
	}

	public function showAddAnswersForm(Question $question) {
		$message = $this->cookieStorage->load($this->quizView->getMessageLocation());
		$this->quizView->unsetMessage($this->quizView->getMessageLocation());			
		$html = "
		<a href='?showQuestion&id=" . $question->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		<h1>MyQuiz</h1>
		<h3>Lägg till svar till " . $question->getName() . "</h3> 
		<form action='' method='post'>
		A)
		<input type='radio' name='rightAnswerCheckBox' value='A'>		
		<input type='text' name='answerA' />
		</br>
		</br>

		B)
		<input type='radio' name='rightAnswerCheckBox' value='B'>
		<input type='text' name='answerB' />
		</br>
		</br>		

		C)
		<input type='radio' name='rightAnswerCheckBox' value='C'>
		<input type='text' name='answerC' />
		</br>
		</br>	

		<input type='submit' name='addAnswers' value='Lägg till' />
		</form> $message";
		return $html;
	}

	public function redirectToAddAnswer($questionId) {
		header("Location: ?addAnswers&id=" . $questionId);		
	}	

	public function hasSubmitAddAnswers() {
		if (isset($_POST['addAnswers'])) {
			return true;
		}
		return false;
	}

	public function getAnswerA() {
		if (isset($_POST['answerA'])) {
			return $_POST['answerA'];
		}		
	}

	public function getAnswerB() {
		if (isset($_POST['answerB'])) {
			return $_POST['answerB'];
		}		
	}

	public function getAnswerC() {
		if (isset($_POST['answerC'])) {
			return $_POST['answerC'];
		}		
	}

	public function getRightAnswerCheckBox() {
		if (isset($_POST['rightAnswerCheckBox'])) {
			return $_POST['rightAnswerCheckBox'];
		}
	}

	public function didUserPressToAddAnswers() {
		if (isset($_GET['addAnswers'])) {
			return true;
		}
		return false;
	}

	public function getId() {
		if (isset($_GET['id'])) {
			return $_GET['id'];
		}
	}
}