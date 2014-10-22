<?php

require_once("View/QuizView.php");
require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");

class AnswerView extends BaseView {

	private static $rightAnswerLocation = "rightAnswerCheckBox";
	private static $answerA = "answerA";
	private static $answerB = "answerB";
	private static $answerC = "answerC";

	public function __construct() {
		$this->quizView = new QuizView();
		$this->cookieStorage = new CookieStorage();
	}

	public function renderCookieMessage($string) {
		$value = $this->cookieStorage->load($string);
		$this->quizView->unsetMessage($string);	
		return $value;
	}

	public function showAddAnswersForm(Question $question) {		
		$message = $this->renderCookieMessage($this->messageLocation);
		$answerA = $this->renderCookieMessage($this->messageALocation);
		$answerB = $this->renderCookieMessage($this->messageBLocation);
		$answerC = $this->renderCookieMessage($this->messageCLocation);

		$html = "
		<a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $question->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		<h1>MyQuiz</h1>
		<h3>Lägg till svar till " . $question->getName() . "</h3> 
		<form action='' method='post'>
		" . $this->alphabets[0] . ")
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[0] . "'>		
		<input type='text' name='" . self::$answerA . "' value='$answerA' />
		</br>
		</br>

		" . $this->alphabets[1] . ")
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[1] . "'>
		<input type='text' name='" .  self::$answerB . "' value='$answerB' />
		</br>
		</br>		

		" . $this->alphabets[2] . ")
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[2] . "'>
		<input type='text' name='" . self::$answerC . "' value='$answerC' />
		</br>
		</br>	

		<input type='submit' name='" . $this->addAnswersLocation . "' value='Lägg till' />
		</form> 
		$message";
		return $html;
	}

	public function redirectToAddAnswers($questionId) {
		header("Location: ?" . $this->addAnswersLocation . "&" . $this->id . "=" . $questionId);		
	}	

	public function hasSubmitAddAnswers() {
		if (isset($_POST[$this->addAnswersLocation])) {
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
		if (isset($_GET[$this->addAnswersLocation])) {
			return true;
		}
		return false;
	}

	public function getId() {
		if (isset($_GET[$this->id])) {
			return $_GET[$this->id];
		}
	}
}