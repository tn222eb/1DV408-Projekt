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

	public function getNumber($string) {
		if ($string == 'A') {
			return 0;
		}	

		if ($string == 'B') {
		    return 1;
		}	

		if ($string == 'C') {
		    return 2;
		}		
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

	public function showResult ($score = 0, $quizId) {
		$userAnswers = $this->getUserAnswers();
		$quiz = $this->quizModel->getQuiz($quizId);
		$questions = $quiz->getQuestions();		
		$questionNr = 1;

		$html = "<a href='?playQuiz=$quizId' >Tillbaka</a>
		<h1>" . $quiz->getName() . "</h1>";				

		if ($userAnswers > 0) {
			foreach ($questions->ToArray() as $questionObj) {
				if (isset($userAnswers[$questionNr])) {	
					$html .= "<h3>$questionNr. " . $questionObj->getName() . "</h3>";
					$question = $this->questionModel->getQuestion($questionObj->getQuestionId());

					foreach ($question->toArray() as $answer) {
						$num = $this->getNumber($userAnswers[$questionNr]);
						if ($userAnswers[$questionNr] != $answer->getRightAnswer()) {
						 	$label = 'question-' . $questionNr . '-answers-'. $answer->getRightAnswer();
						 	$html .= "<div>
						 	<input type='radio' name='answers[$questionNr]' id='$label' value='" . $answer->getAnswer($num) . "' disabled>
						 	<label style='color :red;' for='$label'>" . $userAnswers[$questionNr] . ") " . $answer->getAnswer($num) .  "</label>
					     	</div>";
	        			} else {
	        			 	$label = 'question-' . $questionNr . '-answers-'.  $answer->getRightAnswer();
	            		 	$html .= "<div>
					 		<input type='radio' name='answers[$questionNr]' id='$label' value='" . $answer->getAnswer($num) . "' disabled>
					 		<label style='color: green;' for='$label'>" . $userAnswers[$questionNr] . ") " . $answer->getAnswer($num) .  "</label>
					 		</div>";
	        			}
					}
					$questionNr++;
				}
			}
		}

		return $html .= "
		</br>
		Du fick $score rätt svar av " . count($questions->ToArray());
	}
}
