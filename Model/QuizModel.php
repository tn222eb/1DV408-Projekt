<?php 

require_once("Model/Dao/QuizRepository.php");

class QuizModel {

	private $quizRepository;	

	public function __construct() {
		$this->quizRepository = new QuizRepository();
	}

	public function getAllQuiz() {
		return $this->quizRepository->getQuizList();
	}

	public function getQuiz($quizId) {
		return $this->quizRepository->getQuiz($quizId);
	}

	public function countQuiz($quizName) {
		return count($this->quiz[$quizName]);
	}

	public function validateQuiz($userAnswers, $quizName) {
		$score = 0;

		foreach ($this->quiz[$quizName] as $questionNr => $value) {
			if (isset($userAnswers[$questionNr]) == true) {
				if ($userAnswers[$questionNr] == $value['CorrectAnswer']) {
					$score++;
				}
			}
		}
		return $score;
	}

	public function addQuiz(Quiz $quiz) {
		$this->quizRepository->addQuiz($quiz);
	}

	public function removeQuiz(Quiz $quiz) {
		$this->quizRepository->removeQuiz($quiz);
	}

	public function saveEditQuiz(Quiz $quiz) {
		$this->quizRepository->saveEditQuiz($quiz);
	}
}