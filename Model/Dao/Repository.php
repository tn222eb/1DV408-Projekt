<?php

require_once("Settings.php");

abstract class Repository {
	protected $dbConnection;
    protected $dbTable;
	protected $answerA = "AnswerA";
	protected $answerB = "AnswerB";
	protected $answerC = "AnswerC";
	protected $answerId = "AnswerId";
	protected $rightAnswer = "RightAnswer";
	protected $questionId = "QuestionId"; 
	protected $questionName = 'QuestionName';
	protected $quizId = "QuizId";	  
	protected $result = "Result";
	protected $numberOfQuestions = "NumberOfQuestions";
	protected $userId = "UserId";
	protected $quizName = "QuizName";
	protected $resultId = "ResultId";

    protected function connection() {
    	if ($this->dbConnection == null) {
            $this->dbConnection = new PDO(Settings::$DB_CONNECTION, Settings::$DB_USERNAME, Settings::$DB_PASSWORD);
        
        $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->dbConnection;
    }
  }
}