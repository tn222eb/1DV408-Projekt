<?php

require_once("Model/Quiz.php");
require_once("View/QuizView.php");
require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");

class QuestionView extends BaseView {
	private $questionName = 'questionName';
	private $removeQuestionLocation = 'removeQuestion';
	private $editQuestionLocation = 'editQuestion';
	private $saveEditQuestionLocation = 'saveEditQuestion';
	private $confirmRemoveQuestionLocation = 'confirmRemoveQuestion';

	public function __construct() {
		$this->quizView = new QuizView();
		$this->cookieStorage = new CookieStorage();
	}

	public function getQuestionName() {
		if (isset($_POST[$this->questionName])) {
			return $_POST[$this->questionName];
		}
	}

	public function getId() {
		if (isset($_GET[$this->id])) {
			return $_GET[$this->id];
		}
		return NULL;
	}	

	public function getQuestionMenu($id) {
		return $html = "<a href='?" . $this->addAnswersLocation . "&" . $this->id . "=$id' class='btn btn-default'>Lägg till svar</a>";
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
  	* Show a compilation of quizzes
  	*
  	* @param Object that contains a question
  	*
  	* @return string Returns String HTML
  	*/		
	public function showQuestion(Question $question) {
		$i = 0;
		$message = $this->renderCookieMessage($this->messageLocation);

		$html = "<form action='' method='post'>
		</br>
		<a href='?" . $this->showQuizLocation . "&" . $this->id . "=" . $question->getQuizId() . "' name='returnToPage'>Tillbaka</a> </br> 
		<h2>" . $question->getName() . "</h2>
		<input type='submit' class='btn btn-default' name='" . $this->editQuestionLocation . "' value='Redigera fråga'> <input type='submit' class='btn btn-default' name='" . $this->removeQuestionLocation . "' value='Radera fråga'>
		</br> </br>
		<legend>Svar</legend>
		$message
		<ul style='list-style-type: none;'>";

		if (count($question->toArray()) > 0) {
			foreach($question->toArray() as $answersObj) {
				foreach ($answersObj->getAnswers() as $answerName) {
					$html .= "<li> " . $this->alphabets[$i] . ") " . $answerName ."</li> ";
					$i++;
				}
			}

			$html .= "Rätt svar: <strong style='color: green;'>" . $answersObj->getRightAnswer() . "</strong>";
		}

		if (count($question->toArray()) > 0) {
			$html .= "</ul><input type='submit' class='btn btn-default' name='" . $this->removeAnswersLocation . "' value='Radera svar'></form>";			
		}
		else {
			$html .= "</ul>" . $this->getQuestionMenu($question->getQuestionId()) . "</form>";			
		}

		return $html;		
	}

	/**
  	* Show add question form
  	*
  	* @param Quiz that question gets added to
  	*
  	* @return string Returns String HTML
  	*/	
	public function showAddQuestionForm(Quiz $quiz) {
		$message = $this->renderCookieMessage($this->messageLocation);

		$userUnique = $quiz->getQuizId();
		$html = "</br>
		<a href='?" . $this->showQuizLocation . "&" . $this->id . "=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br> </br>
		<legend>Lägg till fråga till " . $quiz->getName() . "</legend>
		$message 
		<form action='' method='post'>
		<input type='text' name='" . $this->questionName . "' maxlength='150'/>
		</br>
		</br>
		<input type='submit' class='btn btn-default' name='" . $this->addQuestionLocation . "' value='Lägg till' />
		</form>";
		return $html;
	}

	/**
  	* Show edit question form
  	*
  	* @param Object that contains a question
  	*
  	* @return string Returns String HTML
  	*/	
	public function showEditQuestionForm(Question $question) {
		return $html = "</br>
		<a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $question->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<legend>Redigera " 	. $question->getName() . "</legend>
		<form action='' method='post'>
		<input type='text' name='" . $this->questionName . "' value='" . $question->getName() . "' maxlength='150'>
		</br>
		</br>
		<input type='submit' class='btn btn-default' name='" . $this->saveEditQuestionLocation . "' value='Spara'>
		</form>
		 ";
	}

	/**
  	* Confirmation remove page
  	*
  	* @param Object that contains a question
  	*
  	* @return string Returns String HTML
  	*/	
	public function showConfirmToRemoveQuestion(Question $question) {
		return $html = "</br>
		<a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $question->getQuestionId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<legend>Radera " . $question->getName() . "</legend>

		<form action='' method='post'>
		<input type='submit' class='btn btn-default' name='" . $this->confirmRemoveQuestionLocation . "' value='Ta bort'>
		</form>";
	}			

	/**
  	* Functions to see where user wants to do
  	*/	
	public function didUserSubmitAddQuestion() {
		if (isset($_POST[$this->addQuestionLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToAddQuestion() {
		if (isset($_GET[$this->addQuestionLocation])) {
			return true;
		}
		return false;
	}	

	public function didUserPressToShowQuestion() {
		if (isset($_GET[$this->showQuestionLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToRemoveQuestion() {
		if (isset($_POST[$this->removeQuestionLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToEditQuestion() {
		if (isset($_POST[$this->editQuestionLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToSaveEditQuestion() {
		if (isset($_POST[$this->saveEditQuestionLocation])) {
			return true;
		}
		return false;
	}

	public function didUserConfirmToRemoveQuestion() {
		if (isset($_POST[$this->confirmRemoveQuestionLocation])) {
			return true;
		}
		return false;
	}		
}