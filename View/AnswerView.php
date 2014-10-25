<?php

require_once("View/QuizView.php");
require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");

class AnswerView extends BaseView {

	private static $rightAnswerLocation = "rightAnswerCheckBox";
	private static $answerA = "answerA";
	private static $answerB = "answerB";
	private static $answerC = "answerC";
	private $saveEditAnswersLocation = 'saveEditAnswers';
	private $confirmRemoveAnswersLocation = 'confirmRemoveAnswers';

	public function __construct() {
		$this->quizView = new QuizView();
		$this->cookieStorage = new CookieStorage();
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

	public function getId() {
		if (isset($_GET[$this->id])) {
			return $_GET[$this->id];
		}
	}


	/**
  	* Function to redirect
  	*/
	public function redirectToAddAnswers($questionId) {
		header("Location: ?" . $this->addAnswersLocation . "&" . $this->id . "=" . $questionId);		
	}			

	/**
  	* Function to render message
  	*/
	public function renderCookieMessage($string) {
		$value = $this->cookieStorage->load($string);
		$this->quizView->unsetMessage($string);	
		return $value;
	}

	/**
  	* Show edit answers form
  	*
  	* @param Object that contains a answers
  	*
  	* @return string Returns String HTML
  	*/	
	public function showEditAnswersForm(Answers $answers) {
		return $html = "</br>
		<a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $answers->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<legend>Redigera " 	. $answers->getName() . "</legend>
		</br> </br>
		<strong>" . $this->alphabets[0] . "</strong>)
		</br>
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[0] . "'>		
		<input type='text' name='" . self::$answerA . "' value='" . $answers->getAnswerA() . "' maxlength='28'/>
		</br>
		</br>

		<strong>" . $this->alphabets[1] . "</strong>)
		</br>
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[1] . "'>
		<input type='text' name='" .  self::$answerB . "' value='" . $answers->getAnswerB() . "' maxlength='28'/>
		</br>
		</br>		

		<strong>" . $this->alphabets[2] . "</strong>)
		</br>
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[2] . "'>
		<input type='text' name='" . self::$answerC . "' value='" . $answers->getAnswerC() . "' maxlength='28'/>
		</br>
		</br>
		<input type='submit' class='btn btn-default' name='" . $this->saveEditAnswersLocation . "' value='Spara'>
		</form>
		 ";
	}

	/**
  	* Confirmation remove page
  	*
  	* @param Object that contains answers
  	*
  	* @return string Returns String HTML
  	*/	
	public function showConfirmToRemoveAnswers(Answers $answers) {
		return $html = "</br>
		<a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $answers->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<legend>Radera svarsalternativ</legend>

		<form action='' method='post'>
		<input type='submit' class='btn btn-default' name='" . $this->confirmRemoveAnswersLocation . "' value='Ta bort'>
		</form>";
	}			


	/**
  	* Show add answers form
  	*
  	* @param Question that answers is added to
  	*
  	* @return string Returns String HTML
  	*/		
	public function showAddAnswersForm(Question $question) {		
		$message = $this->renderCookieMessage($this->messageLocation);
		$answerA = $this->renderCookieMessage($this->messageALocation);
		$answerB = $this->renderCookieMessage($this->messageBLocation);
		$answerC = $this->renderCookieMessage($this->messageCLocation);

		$html = "</br>
		<a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $question->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		</br> </br>
		<legend>Lägg till svar till " . $question->getName() . "</legend> 
		$message
		<form action='' method='post'>
		<strong>" . $this->alphabets[0] . "</strong>)
		</br>
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[0] . "'>		
		<input type='text' name='" . self::$answerA . "' value='$answerA' maxlength='28'/>
		</br>
		</br>

		<strong>" . $this->alphabets[1] . "</strong>)
		</br>
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[1] . "'>
		<input type='text' name='" .  self::$answerB . "' value='$answerB' maxlength='28'/>
		</br>
		</br>		

		<strong>" . $this->alphabets[2] . "</strong>)
		</br>
		<input type='radio' name='" . self::$rightAnswerLocation . "' value='" . $this->alphabets[2] . "'>
		<input type='text' name='" . self::$answerC . "' value='$answerC' maxlength='28'/>
		</br>
		</br>	

		<input type='submit' class='btn btn-default' name='" . $this->addAnswersLocation . "' value='Lägg till' />
		</form>";
		return $html;
	}

	/**
  	* Functions to see where user wants to do
  	*/	
	public function hasSubmitAddAnswers() {
		if (isset($_POST[$this->addAnswersLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToAddAnswers() {
		if (isset($_GET[$this->addAnswersLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToRemoveAnswers() {
		if (isset($_POST[$this->removeAnswersLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToEditAnswers() {
		if (isset($_POST[$this->editAnswersLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToSaveEditAnswers() {
		if (isset($_POST[$this->saveEditAnswersLocation])) {
			return true;
		}
		return false;
	}

	public function didUserConfirmToRemoveAnswers() {
		if (isset($_POST[$this->confirmRemoveAnswersLocation])) {
			return true;
		}
		return false;
	}	
}