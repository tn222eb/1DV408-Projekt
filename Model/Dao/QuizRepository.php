<?php

require_once("Model/Quiz.php");
require_once("Model/QuizList.php");
require_once("Model/Dao/Repository.php");

class QuizRepository extends Repository{
	private $quizList;
	private $quizName = 'QuizName';
	private $db;

	public function __construct() {
		$this->dbTable = 'quiz';
		$this->quizList = new QuizList();
		$this->db = $this->connection();
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
			return $quiz = new Quiz($result['QuizName'], $result['QuizId']);
		}

		return NULL;
	}
}