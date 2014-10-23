<?php

require_once("View/BaseView.php");
require_once("Model/QuizModel.php");

class ResultView extends BaseView {

	private $quizModel;

	public function __construct() {
		$this->quizModel = new QuizModel();
	}

	/**
  	* Function to see where user wants to do
  	*/
	public function didUserPressGoToShowResults() {
		if (isset($_GET[$this->showResultsLocation])) {
			return true;
		}
		return false;
	}

	/**
  	* Show users quiz results
  	*
  	* @param string Id of Authenticated User
  	*
  	* @return string Returns String HTML
  	*/	
	public function showMyResults($userId) {
		$results = $this->quizModel->getQuizResults($userId);

		$html = "
		</br>
		<a href='?' name='returnToPage'>Tillbaka</a> </br> </br>
		<legend>Mina resultat</legend>

		<ul style='list-style-type: none;'>";

		if ($results == NULL) {
			$html .= "Du har inga resultat";
		}
		else {
			foreach($results as $result) {
				$quiz = $this->quizModel->getQuiz($result->getQuizId());
				$html .= "<li><h4>" . $quiz->getName() . "</h4>" . $result->getScore() . " rätt svar av totalt ". $result->getNumOfQuestions() ."</li>";
			}
		}

		$html .= "</ul>";
		return $html;	
	}
	
}