<?php 

require_once("Model/Dao/QuizRepository.php");
require_once("Model/QuestionModel.php");
require_once("Model/Result.php");
require_once("Model/Quiz.php");

class QuizModel {

	private $quizRepository;	

	public function __construct() {
		$this->quizRepository = new QuizRepository();
		$this->questionModel = new QuestionModel();
	}

	public function getAllQuiz() {
		return $this->quizRepository->getQuizList();
	}

	public function getQuiz($quizId) {
		return $this->quizRepository->getQuiz($quizId);
	}

	public function quizExists($quizName) {
		return $this->quizRepository->quizExists($quizName);
	}

	public function validateQuiz($userAnswers, $quizId) {
		$score = 0;
		$quiz = $this->getQuiz($quizId);
		$questions = $quiz->getQuestions();		
		$questionNr = 1;

		foreach ($questions->toArray() as $questionObj) {
			$question = $this->questionModel->getQuestion($questionObj->getQuestionId());

			foreach ($question->toArray() as $answer) {
				if (isset($userAnswers[$questionNr]) == true) {
					if ($userAnswers[$questionNr] == $answer->getRightAnswer()) {
						$score++;
					}
				}
			}
			$questionNr++;
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

	public function saveQuizResult(Result $result) {
		$this->quizRepository->saveQuizResult($result);
	}

	public function getQuizResults($userId) {
		return $this->quizRepository->getQuizResults($userId);
	}
}