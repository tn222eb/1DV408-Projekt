<?php

require_once("View/QuizMessage.php");
require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");

class QuizView extends BaseView {
	private $cookieStorage;
	private $quizNameLocation = 'quizName';
	private $removeQuizLocation = 'removeQuiz';
	private $editQuizLocation = 'editQuiz';
	private $saveEditQuizLocation = 'saveEditQuiz';
	private $confirmRemoveQuizLocation = 'confirmRemoveQuiz';

	public function __construct() {
		$this->cookieStorage = new CookieStorage();		
	}

	public function getQuizName() {
		if (isset($_POST[$this->quizNameLocation])) {
			return $_POST[$this->quizNameLocation];
		}
	}

	public function getQuizMenu($id) {
		return $html = "<a href='?" . $this->addQuestionLocation . "&" . $this->id . "=$id' class='btn btn-default'>Lägg till fråga</a>";
	}

	public function getId() {
		if (isset($_GET[$this->id])) {
			return $_GET[$this->id];
		}
		return NULL;
	}

	/**
  	* Functions to redirect
  	*/
	public function redirectToShowAllQuiz() {
		header("Location: ?" . $this->showAllQuizLocation . "");		
	}

	public function redirectToShowQuiz($quizId) {
		header("Location: ?" . $this->showQuizLocation . "&" . $this->id . "=" . $quizId);		
	}

	public function redirectToShowCreateQuizForm() {
		header("Location: ?" . $this->createQuizLocation . "");
	}

	public function redirectToAddQuestion($quizId) {
		header("Location: ?" . $this->addQuestionLocation . "&" . $this->id . "=" . $quizId);		
	}	

	/**
  	* Functions to render message
  	*/
	public function renderCookieMessage($string) {
		$value = $this->cookieStorage->load($string);
		$this->unsetMessage($string);	
		return $value;
	}	
	
	public function saveMessage($value) {
		$this->cookieStorage->save($this->messageLocation, $value, time()+3600);
	}

	public function saveValueMessage($name, $value) {
		$this->cookieStorage->save($name, $value, time()+3600);		
	}

	public function unsetMessage($name) {
		$this->cookieStorage->save($name, null, time()-1);
	}

	/**
  	* Functions to see where user wants to go and do
  	*/
	public function didUserPressToShowAllQuiz() {
		if (isset($_GET[$this->showAllQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToSubmitCreateQuiz() {
		if (isset($_POST[$this->createQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressGoToCreateQuiz() {
		if(isset($_GET[$this->createQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToShowQuiz() {
		if(isset($_GET[$this->showQuizLocation])) {
			return true;
		}
		return false;		
	}

	public function didUserPressToRemoveQuiz() {
		if (isset($_POST[$this->removeQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToEditQuiz() {
		if (isset($_POST[$this->editQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressToSaveEditQuiz() {
		if (isset($_POST[$this->saveEditQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserConfirmToRemoveQuiz() {
		if (isset($_POST[$this->confirmRemoveQuizLocation])) {
			return true;
		}
		return false;
	}

	/**
  	* Show create quiz form
  	*
  	* @return string Returns String HTML
  	*/
	public function showCreateQuizForm() {
		$message = $this->renderCookieMessage($this->messageLocation);
		
		$html = "</br>
		<a href='?" . $this->showAllQuizLocation . "' name='returnToPage'>Tillbaka</a>
		</br>	
		</br>
		<legend>Skapa quiz</legend>
		$message
		<form action='?" . $this->createQuizLocation . "' method='post'>
		<input type='text' name='" . $this->quizNameLocation . "' maxlength='60'/>
		</br> </br> <input type='submit' a class='btn btn-default' name='" . $this->createQuizLocation . "' value='Skapa quiz'/>
		</form> ";

		return $html;
	}

	/**
  	* Show a compilation of quizzes
  	*
  	* @param Object that contains quizzes
  	*
  	* @return string Returns String HTML
  	*/	
	public function showAll(QuizList $quizList) {	
		$message = $this->renderCookieMessage($this->messageLocation);

		$html = "</br>
		<a href='?' name='returnToPage'>Tillbaka</a> </br> </br>
		<legend>Lista av alla quiz</legend>
		$message
		<ul style='list-style-type: none;'>";
		foreach ($quizList->toArray() as $quiz) {
			$html .= "<li><a href='?" . $this->showQuizLocation . "&" . $this->id . "=" .
			urlencode($quiz->getQuizId()) . "'>" .
			$quiz->getName() . "</a></li>";
		}
		$html .= "</ul> <a class='btn btn-default' name='" . $this->createQuizLocation . "' href='?" . $this->createQuizLocation . "'>Skapa quiz</a> </br>";
		return $html;
	}

	/**
  	* Show edit quiz form
  	*
  	* @param Object that contains a quiz
  	*
  	* @return string Returns String HTML
  	*/	
	public function showEditQuizForm(Quiz $quiz) {
		return $html = "</br>
		<a href='?" . $this->showQuizLocation . "&" . $this->id . "=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<legend>Redigera " 	. $quiz->getName() . "</legend>
		<form action='' method='post'>
		<input type='text' name='" . $this->quizNameLocation . "' value='" . $quiz->getName() . "'>
		</br>
		</br>
		<input type='submit' class='btn btn-default' name='" . $this->saveEditQuizLocation . "' value='Spara'>
		</form>
		 ";
	}

	/**
  	* Confirmation remove page
  	*
  	* @param Object that contains a quiz
  	*
  	* @return string Returns String HTML
  	*/	
	public function showConfirmToRemoveQuiz(Quiz $quiz) {
		return $html = "</br>
		<a href='?" . $this->showQuizLocation . "&" . $this->id . "=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<legend>Radera " . $quiz->getName() . "</legend>

		<form action='' method='post'>
		<input type='submit' class='btn btn-default' name='" . $this->confirmRemoveQuizLocation . "' value='Ta bort'>
		</form>";
	}

	/**
  	* Show a specific quiz
  	*
  	* @param Object that contains a quiz
  	*
  	* @return string Returns String HTML
  	*/
	public function showQuiz(Quiz $quiz) {
		$message = $this->renderCookieMessage($this->messageLocation);

		$html = "<form action='' method='post'> </br>
		<a href='?" . $this->showAllQuizLocation . "' name='returnToPage'>Tillbaka</a> </br> 
		<h2>" . $quiz->getName() . "</h2>
		<input type='submit' class='btn btn-default' name='" . $this->editQuizLocation . "' value='Redigera " . $quiz->getName() . "'> <input type='submit' class='btn btn-default' name='" . $this->removeQuizLocation . "' value='Radera " . $quiz->getName() . "'>
		</br> </br>
		<legend>Frågor</legend>
		$message
		<ul style='list-style-type: none;'>";
		foreach($quiz->getQuestions()->toArray() as $question) {
			$html .= "<li><a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $question->getQuestionId() . "'>". $question->getName() ."</a></li>";
		}

		$html .= "</ul>" . $this->getQuizMenu($quiz->getQuizId()) . "</form>";
		return $html;		
	}
}