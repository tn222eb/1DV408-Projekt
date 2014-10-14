<?php

require_once("Settings.php");
require_once("Controller/QuizController.php");
require_once("Controller/LoginController.php");
require_once("View/PlayQuizView.php");
require_once("View/QuizView.php");

class MasterController {
	private $loginController;
	private $quizController;
    private $playQuizView;
    private $quizView;
    private $quizRepository;

	public function __construct() {
		$this->loginController = new LoginController();
		$this->quizController = new QuizController();
        $this->playQuizView = new PlayQuizView();
        $this->quizView = new QuizView();
        $this->quizRepository = new QuizRepository();
	}



	public function doControll() {
        try {	
            if ($this->playQuizView->didUserPressGoToShowAllQuizToPlay() || $this->playQuizView->hasChosenQuiz()) {
                if ($this->playQuizView->hasChosenQuiz()) {
                    $this->quizController->playQuiz();
                }
                else {
                    $this->quizController->showAllQuizToPlay();
                }
            }

            else if ($this->quizView->didUserPressToRemoveQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->removeQuiz();
            }

            else if ($this->quizView->didUserPressGoToCreateQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->createQuiz();
            }

            else if ($this->quizView->didUserPressToShowAllQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->showAllQuiz();
            }

            else if ($this->quizView->didUserPressToShowQuiz() && $this->loginController->isAdmin()) {
                // TODO: URL Manipulation With ID
                // TODO: Redirect when remove or add
                $quiz = $this->quizRepository->getQuiz($this->quizView->getId());
                $this->quizController->showQuiz($quiz);
            }

            else {
            	$this->loginController->doControll();
            }
        }
        catch (Exception $e) {
            if (Settings::$DO_DEBUG) {
                throw $e;
            }
            else {
                die("An unknown error has ocurred");
            }
        }		
	}
}