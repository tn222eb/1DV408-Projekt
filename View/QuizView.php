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

	public function didUserPressReturnToPlayQuiz() {
		if (isset($_GET['playQuiz'])) {
			return true;
		}
		return false;
	}

	public function getUserAnswers() {
		return $_POST['answers'];
	}


	public function showQuiz() {
		$questions = $this->quizModel->getQuestions();

		$html = "<a href='?	' >Gå tillbaka</a>
		<form action ='' method='post'>";

		foreach ($questions as $questionNr => $value) {
			$html .= "<h3>" . $value['Question'] . "</h3>";

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

	public function showScore ($score = 0) {
		return $html = "<a href='?	' >Gå tillbaka</a>
		</br>
		</br>
		Resultat: $score/" . $this->quizModel->countQuestions(). "
		";
	}

}