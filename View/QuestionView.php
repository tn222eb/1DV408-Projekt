<?php

require_once("Model/Quiz.php");

class QuestionView {

	private $alphabets = array('A', 'B', 'C');

	public function showAddQuestionForm(Quiz $quiz) {
		$userUnique = $quiz->getQuizId();
		$html = "
		<a href='?showQuiz&id=" . $quiz->getQuizId() . "' name='returnToPage'>Tillbaka</a>
		<h1>MyQuiz</h1>
		<h3>Lägg till fråga till " . $quiz->getName() . "</h3> 
		<form action='' method='post'>
		<input type='text' name='questionName' />
		<input type='submit' name='addQuestion' value='Lägg till' />
		</form>";
		return $html;
	}

	public function didUserPressToShowQuestion() {
		if (isset($_GET['showQuestion'])) {
			return true;
		}
		return false;
	}

	public function showQuestion(Question $question) {
		$i = 0;
		$html = "<form action='' method='post'>
		<a href='?showQuiz&id=" . $question->getQuizId() . "' name='returnToPage'>Tillbaka</a> </br> 
		<h1>" . $question->getName() . "</h1>
		<h3>Svar</h3>
		<ul>";

		if (count($question->toArray()) > 0) {
			foreach($question->toArray() as $answersObj) {
				foreach ($answersObj->getAnswers() as $answerName) {
					$html .= "<li> " . $this->alphabets[$i] . ") " . $answerName ."</li> ";
					$i++;
				}
			}

			$html .= "Rätt svar: " . $answersObj->getRightAnswer() . "";
		}

		if (count($question->toArray()) > 0) {
			$html .= "</ul> </form>";			
		}
		else {
			$html .= "</ul>" . $this->getQuestionMenu($question->getQuestionId()) . "</form>";			
		}

		return $html;		
	}

	public function getQuestionMenu($id) {
		return $html = "<a href='?addAnswers&id=$id'>Lägg till svar</a>";
	}		

	public function didUserSubmitAddQuestion() {
		if (isset($_POST['addQuestion'])) {
			return true;
		}
		return false;
	}

	public function getQuestionName() {
		if (isset($_POST['questionName'])) {
			return $_POST['questionName'];
		}
	}

	public function didUserPressToAddQuestion() {
		if (isset($_GET['addQuestion'])) {
			return true;
		}
		return false;
	}

	public function getId() {
		if (isset($_GET['id'])) {
			return $_GET['id'];
		}
		return NULL;
	}

}