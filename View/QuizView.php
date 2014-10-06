<?php

require_once("Model/QuizModel.php");

class QuizView {

	private $quizModel;

	public function __construct() {
		$this->quizModel = new QuizModel();
	}

	public function hasUserSubmittedAnswers () {
		if (isset($_POST['answers'])) {
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
		<input type='submit' value='Skicka quiz' />
		</form>";
	}

}