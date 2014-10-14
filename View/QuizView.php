<?php

class QuizView {

	public function showCreateQuizForm() {
		$html = "<a href='?' name='returnToPage'>Tillbaka</a> <h1>MyQuiz</h1> <h3>Skapa quiz</h3>";
		$html .= "<form action='?createQuiz' method='post'>";
		$html .= "<input type='text' name='quiz'/>";
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
		if(isset($_POST['quiz'])) {
			return $_POST['quiz'];
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

	public function showQuiz(Quiz $quiz) {
		$html = "<form action='' method='post'>
		<a href='?showAllQuiz' name='returnToPage'>Tillbaka</a> </br>";

		$html .= "<h1>Quiz " . $quiz->getName() . "</h1>";
		$html .= "<input type='submit' name='editQuiz' value='Redigera " . $quiz->getName() . "'> <input type='submit' name='removeQuiz' value='Radera " . $quiz->getName() . "'>";
		$html .= "<h2>Frågor</h2>";
		$html .= "<ul>";
		foreach($quiz->getQuestions()->toArray() as $question) {
			$html .= "<li>". $question->getName() ."</li>";
		}

		$html .= "</ul>" . $this->getQuizMenu($quiz->getQuizId());
		$html .= "</form>";
		return $html;		
	}

	public function getQuizMenu($id) {
		return $html = "
		<a href='?addQuestion&	id=$id'>Lägg till fråga</a>";
	}

	public function getId() {
		if (isset($_GET['id'])) {
			return $_GET['id'];
		}
		return NULL;
	}
	
}