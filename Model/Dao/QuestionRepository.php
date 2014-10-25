<?php

require_once("Model/Answers.php");
require_once("Model/Question.php");
require_once("Model/Dao/Repository.php");

class QuestionRepository extends Repository {
	private $db;
	private $answerTable = "answer";

	public function __construct() {
		$this->dbTable = 'question';
		$this->questions = new Questions();
		$this->db = $this->connection();
	}

	public function isValidQuestionId($id) {
			$sql = "SELECT * FROM $this->dbTable WHERE " . $this->questionId . " = ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == false) {
				return false;
			}
			return true;
	}	

	public function questionExists($questionName) {
			$sql = "SELECT * FROM $this->dbTable WHERE " . $this->questionName . " = ?";
			$params = array($questionName);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == false) {
				return false;
			}
			return true;
	}

	public function addQuestion(Question $question) {
		$sql = "INSERT INTO $this->dbTable (" . $this->questionName . ", " . $this->quizId . ") VALUES (?,?)";
		$params = array($question->getName(), $question->getQuizId());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function removeQuestion(Question $question) {
		$sql = "DELETE FROM $this->dbTable WHERE " . $this->questionId . " = ?";
		$params = array($question->getQuestionId());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function saveEditQuestion(Question $question) {
			$sql = "UPDATE $this->dbTable SET " . $this->questionName . " = ? WHERE " . $this->questionId . " = ?";
			$params = array($question->getName(), $question->getQuestionId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
	}	

	public function getQuestion($questionId) {
		$sql = "SELECT * FROM $this->dbTable WHERE " . $this->questionId . " = ?";
		$params = array($questionId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		if ($result) {
			$question = new Question($result[$this->questionName], $result[$this->quizId], $result[$this->questionId]);

			$sql = "SELECT * FROM " . $this->answerTable . " WHERE " . $this->questionId . " = ?";
			$query = $this->db->prepare($sql);
			$query->execute (array($result[$this->questionId]));
			$answersObj = $query->fetchAll();

			foreach($answersObj as $answerObj) {
				$answers = new Answers($answerObj[$this->answerA], $answerObj[$this->answerB], $answerObj[$this->answerC], $answerObj[$this->rightAnswer], 
				$answerObj[$this->questionId], $answerObj[$this->answerId]);

				$question->add($answers);
			}
			return $question;
		}
		return NULL;
	}	
}