<?php

require_once("Settings.php");
require_once("Controller/QuizController.php");
require_once("Controller/LoginController.php");
require_once("Controller/QuestionController.php");
require_once("View/PlayQuizView.php");
require_once("View/QuizView.php");
require_once("View/QuestionView.php");
require_once("View/AnswerView.php");
require_once("Controller/AnswerController.php");

class MasterController {
	private $loginController;
	private $quizController;
    private $playQuizView;
    private $quizView;
    private $quizRepository;
    private $answerView;

	public function __construct() {
		$this->loginController = new LoginController();
		$this->quizController = new QuizController();
        $this->playQuizView = new PlayQuizView();
        $this->quizView = new QuizView();
        $this->quizRepository = new QuizRepository();
        $this->questionView = new QuestionView();
        $this->questionController = new QuestionController();
        $this->answerView = new AnswerView();
        $this->answerController = new AnswerController();
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

            else if ($this->questionView->didUserPressToAddQuestion() && $this->loginController->isAdmin()) {
                $this->questionController->addQuestion();
            }

            else if ($this->quizView->didUserPressToEditQuiz() && $this->loginController->isAdmin()) {
                $quiz = $this->quizRepository->getQuiz($this->quizView->getId());
                $this->quizController->editQuiz($quiz);
            }

            else if ($this->quizView->didUserPressToSaveEditQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->saveEditQuiz();
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
                // TODO: Validation for input
                $quiz = $this->quizRepository->getQuiz($this->quizView->getId());
                $this->quizController->showQuiz($quiz);
            }

            else if ($this->questionView->didUserPressToShowQuestion() && $this->loginController->isAdmin()) {
                $this->questionController->showQuestion();
            }

            else if ($this->answerView->didUserPressToAddAnswers() && $this->loginController->isAdmin() && $this->answerController->hasNoAnswers()) {
                $this->answerController->addAnswers();
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