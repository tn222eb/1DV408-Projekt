<?php

require_once("Settings.php");
require_once("Controller/QuizController.php");
require_once("Controller/LoginController.php");
require_once("View/QuizView.php");

class MasterController {
	private $loginController;
	private $quizController;
    private $quizView;

	public function __construct() {
		$this->loginController = new LoginController();
		$this->quizController = new QuizController();
        $this->quizView = new QuizView();
	}



	public function doControll() {
        try {	
            if ($this->quizView->didUserPressGoToShowAllQuiz() || $this->quizView->hasChosenQuiz()) {
                if ($this->quizView->hasChosenQuiz()) {
                    $this->quizController->playQuiz();
                }
                else {
                    $this->quizController->showAllQuiz();
                }
            }
            else {
            	$this->loginController->doControll();
            }
        }
           catch (Exception $e){
            if(Settings::$DO_DEBUG) {
                throw $e;
            }
            else {
                die("An unknown error has ocurred");
            }
        }		
	}
}