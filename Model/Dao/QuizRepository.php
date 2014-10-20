<?php

require_once("Model/Quiz.php");
require_once("Model/QuizList.php");
require_once("Model/Dao/Repository.php");

class QuizRepository extends Repository{
	private $quizList;
	private $db;
	private $questionTable = "question";

	public function __construct() {
		$this->dbTable = 'quiz';
		$this->quizList = new QuizList();
		$this->db = $this->connection();
	}

	public function isValidQuizId($id) {
			$sql = "SELECT * FROM $this->dbTable WHERE " . $this->quizId . " = ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == false) {
				return false;
			}
			return true;
	}

	public function quizExists($quizName) {
			$sql = "SELECT * FROM $this->dbTable WHERE " . $this->quizName . " = ?";
			$params = array($quizName);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == false) {
				return false;
			}
			return true;
	}

	public function saveQuizResult($score, $numberofQuestions, $quizId, $userId) {
		$sql = "INSERT INTO results (" . $this->result . ", " . $this->numberOfQuestions . ", " . $this->quizId . ", " . $this->userId . ") VALUES (?,?,?,?)";
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
		$sql = "DELETE FROM $this->dbTable WHERE " . $this->quizId . " = ?";
		$params = array($quiz->getQuizId());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function saveEditQuiz(Quiz $quiz) {
			$sql = "UPDATE $this->dbTable SET " . $this->quizName . " = ? WHERE " . $this->quizId . " = ?";
			$params = array($quiz->getName(), $quiz->getQuizId());
			$query = $this->db->prepare($sql);
			$query->execute($params);	
	}

	public function getQuizList() {
		$sql = "SELECT * FROM $this->dbTable";
		$query = $this->db->prepare($sql);
		$query->execute();

		foreach ($query->fetchAll() as $dbQuizObj) {
			$quizId = $dbQuizObj[$this->quizId];
			$quizName = $dbQuizObj[$this->quizName];
			$quiz = new Quiz($quizName, $quizId);
			$this->quizList->add($quiz);
		}

		return $this->quizList;
	}

	public function getQuiz($quizId) {
		$sql = "SELECT * FROM $this->dbTable WHERE " . $this->quizId . " = ?";
		$params = array($quizId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		if ($result) {
			$quiz = new Quiz($result[$this->quizName], $result[$this->quizId]);

			$sql = "SELECT * FROM " . $this->questionTable . " WHERE " . $this->quizId . " = ?";
			$query = $this->db->prepare($sql);
			$query->execute (array($result[$this->quizId]));
			$questions = $query->fetchAll();

			foreach($questions as $question) {
				$question = new Question($question[$this->questionName], $question[$this->quizId], $question[$this->questionId]);
				$quiz->add($question);
			}
			return $quiz;			
		}
		return NULL;
	}
}