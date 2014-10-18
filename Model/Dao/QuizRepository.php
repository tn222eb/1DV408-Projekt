<?php

require_once("Model/Quiz.php");
require_once("Model/QuizList.php");
require_once("Model/Dao/Repository.php");

class QuizRepository extends Repository{
	private $quizList;
	private $quizName = 'QuizName';
	private $db;
	private $questionTable = "question";

	public function __construct() {
		$this->dbTable = 'quiz';
		$this->quizList = new QuizList();
		$this->db = $this->connection();
	}

	public function isValidQuizId($id) {
			$sql = "SELECT * FROM $this->dbTable WHERE QuizId = ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == false) {
				return false;
			}
			return true;
	}

	public function saveQuizResult($score, $numberofQuestions, $quizId, $userId) {
		$sql = "INSERT INTO Results (Result, NumberOfQuestions, QuizId, UserId) VALUES (?,?,?,?)";
		$params = array($score, $numberofQuestions, $quizId, $userId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}		

	public function addQuiz(Quiz $quiz) {
		$sql = "INSERT INTO $this->dbTable (" . $this->quizName . ") VALUES (?)";
		$params = array($quiz->getName());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function removeQuiz(Quiz $quiz) {
		$sql = "DELETE FROM $this->dbTable WHERE QuizId = ?";
		$params = array($quiz->getQuizId());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function saveEditQuiz(Quiz $quiz) {
			$sql = "UPDATE $this->dbTable SET " . $this->quizName . " = ? WHERE QuizId = ?";
			$params = array($quiz->getName(), $quiz->getQuizId());
			$query = $this->db->prepare($sql);
			$query->execute($params);	
	}

	public function getQuizList() {
		$sql = "SELECT * FROM $this->dbTable";
		$query = $this->db->prepare($sql);
		$query->execute();

		foreach ($query->fetchAll() as $dbQuizObj) {
			$quizId = $dbQuizObj['QuizId'];
			$quizName = $dbQuizObj['QuizName'];
			$quiz = new Quiz($quizName, $quizId);
			$this->quizList->add($quiz);
		}

		return $this->quizList;
	}

	public function getQuiz($quizId) {
		$sql = "SELECT * FROM $this->dbTable WHERE QuizId = ?";
		$params = array($quizId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		if ($result) {
			$quiz = new Quiz($result['QuizName'], $result['QuizId']);

			$sql = "SELECT * FROM " . $this->questionTable . " WHERE QuizId = ?";
			$query = $this->db->prepare($sql);
			$query->execute (array($result['QuizId']));
			$questions = $query->fetchAll();

			foreach($questions as $question) {
				$question = new Question($question['QuestionName'], $question['QuizId'], $question['QuestionId']);
				$quiz->add($question);
			}
			return $quiz;			
		}
		return NULL;
	}
}