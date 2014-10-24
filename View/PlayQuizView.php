<?php

require_once("Model/QuizModel.php");
require_once("View/BaseView.php");

class PlayQuizView extends BaseView {

	private $submitQuizLocation = 'submitQuiz';
	private $answersLocation = 'answers';
	private $quizModel;
	private $userAnswers = array();
	private $questionModel;

	public function __construct() {
		$this->quizModel = new QuizModel();
		$this->questionModel = new QuestionModel();
	}

	public function getChosenQuiz() {
		if (isset($_GET[$this->playQuizLocation])) {
			return $_GET[$this->playQuizLocation];
		}
	}	

	public function getUserAnswers() {
		if(isset($_POST[$this->answersLocation])) {
			return $_POST[$this->answersLocation];
		}
	}	

	/**
  	* Get a specific number based on char
  	*
  	* @param char from user answers from quiz
  	*
  	* @return string Returns a number 
  	*/	
	public function getNumber($string) {
		if ($string == $this->alphabets[0]) {
			return 0;
		}	

		if ($string == $this->alphabets[1]) {
		    return 1;
		}	

		if ($string == $this->alphabets[2]) {
		    return 2;
		}		
	}	

	/**
  	* Functions to see where user wants to go and do
  	*/
	public function hasUserSubmitQuiz () {
		if (isset($_POST[$this->submitQuizLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressGoToShowAllQuizToPlay() {
		if (isset($_GET[$this->showAllQuizToPlayLocation])) {
			return true;
		}
		return false;
	}

	public function hasChosenQuiz() {
		if (isset($_GET[$this->playQuizLocation])) {
			return true;
		}		
		return false;
	}

	/**
  	* Show all quizzes possible to play
  	*
  	* @return string Returns String HTML
  	*/
	public function showAllQuizToPlay() {
		$html = "</br>
		<a href='?'>Tillbaka</a>
		</br> </br>
		<legend>Välj quiz att spela</legend>
		<ul style='list-style-type: none;'>";

		$quizList = $this->quizModel->getOnlyPlayableQuizzes();
		foreach ($quizList->ToArray() as $quiz) {
			$html .= "<li><a href='?$this->playQuizLocation=" . $quiz->getQuizId() . "'>" . $quiz->getName() . "</a></li>";
		}

		return $html .= "</ul>";
	}

	/**
  	* Show form to play chosen quiz
  	*
  	* @param Id of quiz to play 
  	*
  	* @return string Returns String HTML
  	*/
	public function showPlayQuiz($quizId) {
		$quiz = $this->quizModel->getQuiz($quizId);
		$questions = $quiz->getQuestions();
		$questionNr = 1;

		$html = "
		</br>
		<a href='?$this->showAllQuizToPlayLocation' >Tillbaka</a>
		<h2>" . $quiz->getName() . "</h2>
		<form action ='' method='post'>";

			foreach ($questions->ToArray() as $question) {
				$question = $this->questionModel->getQuestion($question->getQuestionId());

				foreach ($question->toArray() as $answer) {
					$foo = 0;

					if ($answer != null) {
						$html .= "<h4>$questionNr. " . $question->getName() . "</h4>";
					}

					foreach ($answer->getAnswers() as $answerName) {
						$label = 'question-' . $questionNr . '-answers-'. $this->alphabets[$foo];

						$html .=
						"<div>
						<input type='radio' name='answers[$questionNr]' id='$label' value='" . $this->alphabets[$foo] . "'> 
						<small><label for='$label'>" . $this->alphabets[$foo] . ") " . $answerName . "</label></small>
						</div>";
						
						$foo++;
					}
				}
				$questionNr++;
			}

		return $html .= "</br>
		<input type='submit' class='btn btn-default' name='$this->submitQuizLocation' value='Skicka quiz' />
		</form>
		</br>
		";
	}

	/**
  	* Show result from quiz
  	*
  	* @param score of user quiz
  	*
  	* @param Id of quiz user played 
  	*  	
  	* @return string Returns String HTML
  	*/
	public function showResult ($score = 0, $quizId) {
		$userAnswers = $this->getUserAnswers();
		$quiz = $this->quizModel->getQuiz($quizId);
		$questions = $quiz->getQuestions();		
		$questionNr = 1;

		$html = "</br>
		<a href='?$this->showAllQuizToPlayLocation' >Tillbaka</a>
		</br>
		<a href='?$this->playQuizLocation=$quizId' >Spela igen</a>
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
						 	<small><label style='color :red;' for='$label'>" . $userAnswers[$questionNr] . ") " . $answer->getAnswer($num) .  "</label></small>
					     	</div>";
	        			} else {
	        			 	$label = 'question-' . $questionNr . '-answers-'.  $answer->getRightAnswer();
	            		 	$html .= "<div>
					 		<input type='radio' name='answers[$questionNr]' id='$label' value='" . $answer->getAnswer($num) . "' disabled>
					 		<small><label style='color: green;' for='$label'>" . $userAnswers[$questionNr] . ") " . $answer->getAnswer($num) .  "</label></small>
					 		</div>";
	        			}
					}
				}
				$questionNr++;
			}
		}

		return $html .= "
		</br>
		Du fick $score rätt svar av totalt " . count($questions->ToArray()) . "</br></br>";
	}
}
