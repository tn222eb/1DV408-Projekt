<?php

require_once("Model/QuizModel.php");

class PlayQuizView {

	private $alphabets = array('A', 'B', 'C');
	private $submitQuizLocation = 'submitQuiz';
	private $quizModel;
	private $userAnswers = array();
	private $showAllQuizToPlay = 'showAllQuizToPlay';
	private $questionModel;

	public function __construct() {
		$this->quizModel = new QuizModel();
		$this->questionModel = new QuestionModel();
	}

	public function hasUserSubmitQuiz () {
		if (isset($_POST[$this->submitQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressGoToShowAllQuizToPlay() {
		if (isset($_GET[$this->showAllQuizToPlay])) {
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
	}

	public function hasChosenQuiz() {
		if (isset($_GET['playQuiz'])) {
			return true;
		}		
		return false;
	}

	public function showAllQuizToPlay() {
		$html = "
		<a href='?'>Tillbaka</a>
		<h1>MyQuiz</h1>
		<h3>Välj quiz att spela</h3>
		<ul>";

		$quizList = $this->quizModel->getAllQuiz();
		foreach ($quizList->ToArray() as $quiz) {
			$html .= "<li><a href='?playQuiz=" . $quiz->getQuizId() . "'>" . $quiz->getName() . "</a></li>";
		}

		return $html .= "</ul>";
	}

	public function showPlayQuiz($quizId) {
		$quiz = $this->quizModel->getQuiz($quizId);
		$questions = $quiz->getQuestions();
		$questionNr = 1;

		$html = "<a href='?$this->showAllQuizToPlay' >Tillbaka</a>
		<h1>" . $quiz->getName() . "</h1>
		<form action ='' method='post'>";

			foreach ($questions->ToArray() as $question) {
				$html .= "<h3>$questionNr. " . $question->getName() . "</h3>";
				$question = $this->questionModel->getQuestion($question->getQuestionId());


				foreach ($question->toArray() as $answer) {
					$foo = 0;

					foreach ($answer->getAnswers() as $answerName) {
						$label = 'question-' . $questionNr . '-answers-'. $this->alphabets[$foo];

						$html .=
						"<div>
						<input type='radio' name='answers[$questionNr]' id='$label' value='" . $this->alphabets[$foo] . "'> 
						<label for='$label'>" . $this->alphabets[$foo] . ") " . $answerName . "</label>
						</div>";
						
						$foo++;
					}
				}
				$questionNr++;
			}

		return $html .= "</br>
		<input type='submit' name='$this->submitQuizLocation' value='Skicka quiz' />
		</form>";
	}

	public function showResult ($score = 0, $quizName) {

		$userAnswers = $this->getUserAnswers();
		$quiz = $this->quizModel->getQuiz($quizName);

		$html = "<a href='?$this->showAllQuizToPlay' >Tillbaka</a>
		<h1>$quizName</h1>";				

		if ($userAnswers > 0) {
		foreach ($quiz as $questionNr => $value) {
			$html .= "<h3>$questionNr. " . $value['Question'] . "</h3>";

				if ($userAnswers[$questionNr] != $value['CorrectAnswer']) {
					 $label = 'question-' . $questionNr . '-answers-'. $value['CorrectAnswer'];
					 $html .= "<div>
					 <input type='radio' name='answers[$questionNr]' id='$label' value='" . $value['Answers'][$userAnswers[$questionNr]] . "' disabled>
					 <label style='color :red;' for='$label'>" . $value['CorrectAnswer'] . ") " . $value['Answers'][$userAnswers[$questionNr]] . "</label>
				     </div>";
        		} else {
        			 $label = 'question-' . $questionNr . '-answers-'. $value['CorrectAnswer'];
            		 $html .= "<div>
					 <input type='radio' name='answers[$questionNr]' id='$label' value='" . $value['Answers'][$userAnswers[$questionNr]] . "' disabled>
					 <label style='color: green;' for='$label'>" . $value['CorrectAnswer'] . ") " . $value['Answers'][$userAnswers[$questionNr]] . "</label>
					 </div>";
        		}
			}
		}

		return $html .= "
		</br>
		Resultat: $score/" . $this->quizModel->countQuiz($quizName) . "
		";
	}
}