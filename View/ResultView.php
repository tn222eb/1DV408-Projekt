<?php

require_once("View/BaseView.php");
require_once("Model/QuizModel.php");

class ResultView extends BaseView {

	private $quizModel;

	public function __construct() {
		$this->quizModel = new QuizModel();
	}

	public function didUserPressGoToShowAllQuizToPlay() {
		if (isset($_GET[$this->showResultsLocation])) {
			return true;
		}
		return false;
	}

	public function showMyResults($userId) {
		$results = $this->quizModel->getQuizResults($userId);

		$html = "
		<a href='?' name='returnToPage'>Tillbaka</a> </br> 
		<h1>Mina resultat</h1>

		<ul>";

		if ($results == NULL) {
			$html .= "Du har inga resultat";
		}
		else {
			foreach($results as $result) {
				$quiz = $this->quizModel->getQuiz($result->getQuizId());
				$html .= "<li><h3>" . $quiz->getName() . "</h3>" . $result->getScore() . " rätt svar av totalt ". $result->getNumOfQuestions() ."</li>";
			}
		}

		$html .= "</ul>";
		return $html;	
	}
	
}