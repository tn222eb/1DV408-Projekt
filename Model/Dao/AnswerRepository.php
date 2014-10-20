<?php

require_once("Model/Dao/Repository.php");
require_once("Model/Answers.php");

class AnswerRepository extends Repository {
	private $db;

	public function __construct() {
		$this->dbTable = 'answer';
		$this->db = $this->connection();
	}

	public function addAnswers(Answers $answers) {
		$sql = "INSERT INTO $this->dbTable (" . $this->answerA . ", " . $this->answerB . ", " . $this->answerC . ", " . $this->rightAnswer . ", " . $this->questionId . ") VALUES (?,?,?,?,?)";
		$params = array($answers->getAnswer(0), $answers->getAnswer(1), $answers->getAnswer(2), $answers->getRightAnswer(), $answers->getQuestionId());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}	
}