<?php

require_once("View/QuizMessage.php");
require_once("helper/CookieStorage.php");

class QuizView {
	private $cookieStorage;
	private $messageLocation = "CookieMessage";

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
		header("Location: ?showAllQuiz");		
	}

	public function redirectToShowQuiz($quizId) {
		header("Location: ?showQuiz&id=" . $quizId);		
	}

	public function redirectToShowCreateQuizForm() {
		header("Location: ?createQuiz");
	}

	public function redirectToAddQuestion($quizId) {
		header("Location: ?addQuestion&id=" . $quizId);		
	}

	public function showCreateQuizForm() {
		$message = $this->cookieStorage->load($this->messageLocation);
		$this->unsetMessage($this->messageLocation);
		$html = "<a href='?showAllQuiz' name='returnToPage'>Tillbaka</a> <h1>MyQuiz</h1> <h3>Skapa quiz</h3>";
		$html .= "<form action='?createQuiz' method='post'>";
		$html .= "<input type='text' name='quizName' maxlength='60'/>";
		$html .= "</br> </br> <input type='submit' name='createQuiz' value='Skapa quiz'/>";
		$html .= "</form> $message";

		return $html;
	}

	public function didUserPressToShowAllQuiz() {
		if (isset($_GET['showAllQuiz'])) {
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
			$html .= "<li><a href='?showQuiz&id=" .
			urlencode($quiz->getQuizId()) . "'>" .
			$quiz->getName() . "</a></li>";
		}
		$html .= "</ul> <a class='btn btn-default' name='CreateQuiz' href='?createQuiz'>Skapa quiz</a> </br> $message";
		return $html;
	}	

	public function getQuizName() {
		if(isset($_POST['quizName'])) {
			return $_POST['quizName'];
		}
	}

	public function didUserPressToSubmitCreateQuiz() {
		if (isset($_POST['createQuiz'])) {
			return true;
		}
		return false;
	}

	public function didUserPressGoToCreateQuiz() {
		if(isset($_GET['createQuiz'])) {
			return true;
		}
		return false;
	}

	public function didUserPressToShowQuiz() {
		if(isset($_GET['showQuiz'])) {
			return true;
		}
		return false;		
	}

	public function didUserPressToRemoveQuiz() {
		if (isset($_POST['removeQuiz'])) {
			return true;
		}
		return false;
	}

	public function didUserPressToEditQuiz() {
		if (isset($_POST['editQuiz'])) {
			return true;
		}
		return false;
	}

	public function didUserPressToSaveEditQuiz() {
		if (isset($_POST['saveEditQuiz'])) {
			return true;
		}
		return false;
	}

	public function didUserConfirmToRemoveQuiz() {
		if (isset($_POST['confirmRemoveQuiz'])) {
			return true;
		}
		return false;
	}

	public function showEditQuizForm(Quiz $quiz) {
		return $html = "<a href='?showQuiz&id=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<h1>Redigera " 	. $quiz->getName() . "</1>
		<form action='' method='post'>
		<input type='text' name='quizName' value='" . $quiz->getName() . "'>
		<input type='submit' name='saveEditQuiz' value='Spara'>
		</form>
		 ";
	}

	public function showConfirmToRemoveQuiz(Quiz $quiz) {
		return $html = "<a href='?showQuiz&id=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		</br>
		</br>
		<h1>Är du säker att du vill ta bort " . $quiz->getName() . "</1>
		<form action='' method='post'>
		<input type='submit' name='confirmRemoveQuiz' value='Ja, Ta bort'>
		</form>
		 ";
	}

	public function showQuiz(Quiz $quiz) {
		$message = $this->cookieStorage->load($this->messageLocation);
		$this->unsetMessage($this->messageLocation);

		$html = "<form action='' method='post'>
		<a href='?showAllQuiz' name='returnToPage'>Tillbaka</a> </br> 
		<h1>" . $quiz->getName() . "</h1>
		<input type='submit' name='editQuiz' value='Redigera " . $quiz->getName() . "'> <input type='submit' name='removeQuiz' value='Radera " . $quiz->getName() . "'>
		<h3>Frågor</h3>
		<ul>";
		foreach($quiz->getQuestions()->toArray() as $question) {
			$html .= "<li><a href='?showQuestion&id=" . $question->getQuestionId() . "'>". $question->getName() ."</a></li>";
		}

		$html .= "</ul>" . $this->getQuizMenu($quiz->getQuizId()) . "</form> $message";
		return $html;		
	}

	public function getQuizMenu($id) {
		return $html = "
		<a href='?addQuestion&id=$id'>Lägg till fråga</a>";
	}

	public function getId() {
		if (isset($_GET['id'])) {
			return $_GET['id'];
		}
		return NULL;
	}
}