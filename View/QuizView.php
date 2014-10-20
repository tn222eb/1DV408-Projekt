<?php

require_once("View/QuizMessage.php");
require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");

class QuizView extends BaseView {
	private $cookieStorage;
	private $messageLocation = "CookieMessage";
	private $quizNameLocation = 'quizName';
	private $removeQuizLocation = 'removeQuiz';
	private $editQuizLocation = 'editQuiz';
	private $saveEditQuizLocation = 'saveEditQuiz';
	private $confirmRemoveQuizLocation = 'confirmRemoveQuiz';

	public function __construct() {
		$this->cookieStorage = new CookieStorage();		
	}

	public function getMessageLocation() {
		return $this->messageLocation;
	}

	public function saveMessage($value) {
		$this->cookieStorage->save($this->messageLocation, $value, time()+3600);
	}

	public function unsetMessage($name) {
		$this->cookieStorage->save($name, null, time()-1);
	}

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

	public function showCreateQuizForm() {
		$message = $this->cookieStorage->load($this->messageLocation);
		$this->unsetMessage($this->messageLocation);
		
		$html = "<a href='?" . $this->showAllQuizLocation . "' name='returnToPage'>Tillbaka</a> <h1>MyQuiz</h1> <h3>Skapa quiz</h3>
		<form action='?" . $this->createQuizLocation . "' method='post'>
		<input type='text' name='" . $this->quizNameLocation . "' maxlength='60'/>
		</br> </br> <input type='submit' name='" . $this->createQuizLocation . "' value='Skapa quiz'/>
		</form> $message";

		return $html;
	}

	public function didUserPressToShowAllQuiz() {
		if (isset($_GET[$this->showAllQuizLocation])) {
			return true;
		}
		return false;
	}

	public function showAll(QuizList $quizList) {	
		$message = $this->cookieStorage->load($this->messageLocation);
		$this->unsetMessage($this->messageLocation);
		$html = "<a href='?' name='returnToPage'>Tillbaka</a> <h1>MyQuiz</h1> <h3>Lista av alla quiz</h3>";
		$html .= "<ul>";
		foreach ($quizList->toArray() as $quiz) {
			$html .= "<li><a href='?" . $this->showQuizLocation . "&" . $this->id . "=" .
			urlencode($quiz->getQuizId()) . "'>" .
			$quiz->getName() . "</a></li>";
		}
		$html .= "</ul> <a class='btn btn-default' name='" . $this->createQuizLocation . "' href='?" . $this->createQuizLocation . "'>Skapa quiz</a> </br> $message";
		return $html;
	}	

	public function getQuizName() {
		if(isset($_POST[$this->quizNameLocation])) {
			return $_POST[$this->quizNameLocation];
		}
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

	public function showEditQuizForm(Quiz $quiz) {
		return $html = "<a href='?" . $this->showQuizLocation . "&" . $this->id . "=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<h1>Redigera " 	. $quiz->getName() . "</1>
		<form action='' method='post'>
		<input type='text' name='" . $this->quizNameLocation . "' value='" . $quiz->getName() . "'>
		<input type='submit' name='" . $this->saveEditQuizLocation . "' value='Spara'>
		</form>
		 ";
	}

	public function showConfirmToRemoveQuiz(Quiz $quiz) {
		return $html = "<a href='?" . $this->showQuizLocation . "&" . $this->id . "=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<h1>Är du säker att du vill ta bort " . $quiz->getName() . "</1>
		<form action='' method='post'>
		<input type='submit' name='" . $this->confirmRemoveQuizLocation . "' value='Ja, Ta bort'>
		</form>
		 ";
	}

	public function showQuiz(Quiz $quiz) {
		$message = $this->cookieStorage->load($this->messageLocation);
		$this->unsetMessage($this->messageLocation);

		$html = "<form action='' method='post'>
		<a href='?" . $this->showAllQuizLocation . "' name='returnToPage'>Tillbaka</a> </br> 
		<h1>" . $quiz->getName() . "</h1>
		<input type='submit' name='" . $this->editQuizLocation . "' value='Redigera " . $quiz->getName() . "'> <input type='submit' name='" . $this->removeQuizLocation . "' value='Radera " . $quiz->getName() . "'>
		<h3>Frågor</h3>
		<ul>";
		foreach($quiz->getQuestions()->toArray() as $question) {
			$html .= "<li><a href='?" . $this->showQuestionLocation . "&" . $this->id . "=" . $question->getQuestionId() . "'>". $question->getName() ."</a></li>";
		}

		$html .= "</ul>" . $this->getQuizMenu($quiz->getQuizId()) . "</form> $message";
		return $html;		
	}

	public function getQuizMenu($id) {
		return $html = "
		<a href='?" . $this->addQuestionLocation . "&" . $this->id . "=$id'>Lägg till fråga</a>";
	}

	public function getId() {
		if (isset($_GET[$this->id])) {
			return $_GET[$this->id];
		}
		return NULL;
	}
}