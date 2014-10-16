<?php

class QuizView {

	public function showCreateQuizForm() {
		$html = "<a href='?' name='returnToPage'>Tillbaka</a> <h1>MyQuiz</h1> <h3>Skapa quiz</h3>";
		$html .= "<form action='?createQuiz' method='post'>";
		$html .= "<input type='text' name='quizName'/>";
		$html .= "</br> </br> <input type='submit' name='createQuiz' value='Skapa quiz' />";
		$html .= "</form>";

		return $html;
	}

	public function didUserPressToShowAllQuiz() {
		if (isset($_GET['showAllQuiz'])) {
			return true;
		}
		return false;
	}

	public function showAll(QuizList $quizList) {	
		$html = "<a href='?' name='returnToPage'>Tillbaka</a> <h1>MyQuiz</h1> <h3>Lista av alla quiz</h3>";
		$html .= "<ul>";
		foreach ($quizList->toArray() as $quiz) {
			$html .= "<li><a href='?showQuiz&id=" .
			urlencode($quiz->getQuizId()) . "'>" .
			$quiz->getName() . "</a></li>";
		}
		$html .= "</ul>";
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

	public function showQuiz(Quiz $quiz) {
		$html = "<form action='' method='post'>
		<a href='?showAllQuiz' name='returnToPage'>Tillbaka</a> </br> 
		<h1>" . $quiz->getName() . "</h1>
		<input type='submit' name='editQuiz' value='Redigera " . $quiz->getName() . "'> <input type='submit' name='removeQuiz' value='Radera " . $quiz->getName() . "'>
		<h3>Frågor</h3>
		<ul>";
		foreach($quiz->getQuestions()->toArray() as $question) {
			$html .= "<li><a href='?showQuestion&id=" . $question->getQuestionId() . "'>". $question->getName() ."</a></li>";
		}

		$html .= "</ul>" . $this->getQuizMenu($quiz->getQuizId()) . "</form>";
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