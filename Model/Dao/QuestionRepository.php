<?php

require_once("Model/Answers.php");
require_once("Model/Question.php");
require_once("Model/Dao/Repository.php");

class QuestionRepository extends Repository {
	private $questionName = 'QuestionName';
	private $quizId = 'QuizId';
	private $db;
	private $answerTable = "answer";

	public function __construct() {
		$this->dbTable = 'question';
		$this->questions = new Questions();
		$this->db = $this->connection();
	}

	public function addQuestion(Question $question) {
		$sql = "INSERT INTO $this->dbTable (" . $this->questionName . ", " . $this->quizId .") VALUES (?,?)";
		$params = array($question->getName(), $question->getQuizId());
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function getQuestion($questionId) {
		$sql = "SELECT * FROM $this->dbTable WHERE QuestionId = ?";
		$params = array($questionId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		if ($result) {
			$question = new Question($result[$this->questionName], $result['QuizId'], $result['QuestionId']);

			$sql = "SELECT * FROM " . $this->answerTable . " WHERE QuestionId = ?";
			$query = $this->db->prepare($sql);
			$query->execute (array($result['QuestionId']));
			$answersObj = $query->fetchAll();

			foreach($answersObj as $answerObj) {
				$answers = new Answers($answerObj['AnswerA'], $answerObj['AnswerB'], $answerObj['AnswerC'], $answerObj['RightAnswer'], 
				$answerObj['QuestionId'], $answerObj['AnswerId']);

				$question->add($answers);
			}
			return $question;
		}
		return NULL;
	}	
}