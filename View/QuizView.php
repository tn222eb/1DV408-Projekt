<?php

require_once("Model/QuizModel.php");

class QuizView {

	private $submitQuizLocation = 'submitQuiz';
	private $quizModel;
	private $userAnswers = array();

	public function __construct() {
		$this->quizModel = new QuizModel();
	}

	public function hasUserSubmitQuiz () {
		if (isset($_POST[$this->submitQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressGoToChoiceQuiz() {
		if (isset($_GET['showAllQuiz'])) {
			return true;
		}
		return false;
	}

	public function getUserAnswers() {
		if(isset($_POST['answers'])) {
			return $_POST['answers'];
		}
	}

	public function getChosenQuiz() {
		if (isset($_GET['playQuiz'])) {
			return $_GET['playQuiz'];
		}
		return false;
	}

	public function showAllQuiz() {
		$html = "
		<a href='?'>Gå tillbaka</a>
		<h1>MyQuiz</h1>
		<h3>Välj quiz att spela</h3>
		<ul>";

		$arrayOfQuizNames = $this->quizModel->getAllQuiz();
		foreach ($arrayOfQuizNames as $quizName) {
			$html .= "<li><a href='?playQuiz=$quizName'>$quizName</a></li>";
		}

		return $html .= "</ul>";
	}

	public function showQuiz($quizName) {
		$quiz = $this->quizModel->getQuiz($quizName);

		$html = "<a href='?showAllQuiz' >Gå tillbaka</a>
		<form action ='' method='post'>";

		foreach ($quiz as $questionNr => $value) {
			$html .= "<h3>$questionNr. " . $value['Question'] . "</h3>";

			foreach ($value['Answers'] as $char => $answer) {
				$label = 'question-' . $questionNr . '-answers-'. $char;

				$html .=
				"<div>
				<input type='radio' name='answers[$questionNr]' id='$label' value='$char'> 
				<label for='$label'>$char) $answer</label>
				</div>";
			}
		}

		return $html .= "</br>
		<input type='submit' name='$this->submitQuizLocation' value='Skicka quiz' />
		</form>";
	}

	public function showScore ($score = 0, $quizName) {
		return $html = "<a href='?showAllQuiz' >Gå tillbaka</a>
		</br>
		</br>
		Resultat: $score/" . $this->quizModel->countQuiz($quizName) . "
		";
	}

}