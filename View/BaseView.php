<?php

require_once("Settings.php");

abstract class BaseView {
    protected $logOutLocation = 'logOut';
    protected $showAllQuizToPlayLocation = 'showAllQuizToPlay';
    protected $showAllQuizLocation = 'showAllQuiz';	
    protected $playQuizLocation = 'playQuiz';
    protected $createQuizLocation = 'createQuiz';
    protected $showQuizLocation = 'showQuiz';
    protected $addQuestionLocation = 'addQuestion';
    protected $showQuestionLocation = 'showQuestion';
    protected $id = 'id';
    protected $addAnswersLocation = "addAnswers";
    protected $alphabets = array('A', 'B', 'C');
    protected $showResultsLocation = "showResults";

    public static function redirectToErrorPage() {
        header("Location: /". Settings::$ROOT_PATH . "/error.html");
    }
}