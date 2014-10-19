<?php

require_once("View/QuizView.php");
require_once("helper/CookieStorage.php");

class AnswerView {

	private static $rightAnswerLocation = "rightAnswerCheckBox";
	private static $addAnswerLocation = "addAnswers";
	private static $answerA = "answerA";
	private static $answerB = "answerB";
	private static $answerC = "answerC";
	private static $id = "id";

	public function __construct() {
		$this->quizView = new QuizView();
		$this->cookieStorage = new CookieStorage();
	}

	public function showAddAnswersForm(Question $question) {
		$message = $this->cookieStorage->load($this->quizView->getMessageLocation());
		$this->quizView->unsetMessage($this->quizView->getMessageLocation());			
		$html = "
		<a href='?showQuestion&" . self::$id . "=" . $question->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		<h1>MyQuiz</h1>
		<h3>Lägg till svar till " . $question->getName() . "</h3> 
		<form action='' method='post'>
		A)
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='A'>		
		<input type='text' name='" . self::$answerA . "' value='' />
		</br>
		</br>

		B)
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='B'>
		<input type='text' name='" .  self::$answerB . "' value='' />
		</br>
		</br>		

		C)
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='C'>
		<input type='text' name='" . self::$answerC . "' value='' />
		</br>
		</br>	

		<input type='submit' name='" . self::$addAnswerLocation . "' value='Lägg till' />
		</form> 
		$message";
		return $html;
	}

	public function redirectToAddAnswer($questionId) {
		header("Location: ?$this->$addAnswerLocation&" . self::$id . "=" . $questionId);		
	}	

	public function hasSubmitAddAnswers() {
		if (isset($_POST[self::$addAnswerLocation])) {
			return true;
		}
		return false;
	}

	public function getAnswerA() {
		if (isset($_POST[self::$answerA])) {
			return $_POST[self::$answerA];
		}		
	}

	public function getAnswerB() {
		if (isset($_POST[self::$answerB])) {
			return $_POST[self::$answerB];
		}		
	}

	public function getAnswerC() {
		if (isset($_POST[self::$answerC])) {
			return $_POST[self::$answerC];
		}		
	}

	public function getRightAnswerCheckBox() {
		if (isset($_POST[self::$rightAnswerLocation])) {
			return $_POST[self::$rightAnswerLocation];
		}
	}

	public function didUserPressToAddAnswers() {
		if (isset($_GET[self::$addAnswerLocation])) {
			return true;
		}
		return false;
	}

	public function getId() {
		if (isset($_GET[self::$id])) {
			return $_GET[self::$id];
		}
	}
}