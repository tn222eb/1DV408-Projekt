<?php

require_once("Settings.php");
require_once("View/BaseView.php");
require_once("Controller/QuizController.php");
require_once("Controller/LoginController.php");
require_once("Controller/QuestionController.php");
require_once("View/PlayQuizView.php");
require_once("View/QuizView.php");
require_once("View/QuestionView.php");
require_once("View/AnswerView.php");
require_once("Controller/AnswerController.php");
require_once("Model/Dao/QuestionRepository.php");
require_once("Model/Dao/QuizRepository.php");
require_once("View/ResultView.php");

class MasterController {
	private $loginController;
	private $quizController;
    private $playQuizView;
    private $quizView;
    private $quizRepository;
    private $answerView;
    private $resultView;
    private $answerRepository;

	public function __construct() {
		$this->loginController = new LoginController();
		$this->quizController = new QuizController();
        $this->playQuizView = new PlayQuizView();
        $this->quizView = new QuizView();
        $this->quizRepository = new QuizRepository();
        $this->answerRepository = new AnswerRepository();
        $this->questionRepository = new QuestionRepository();
        $this->questionView = new QuestionView();
        $this->questionController = new QuestionController();
        $this->answerView = new AnswerView();
        $this->answerController = new AnswerController();
        $this->resultView = new ResultView();
	}

	public function doControll() {
        try {	
            if ($this->playQuizView->didUserPressGoToShowAllQuizToPlay() && $this->loginController->isAuthenticated() || $this->playQuizView->hasChosenQuiz() && $this->loginController->isAuthenticated()) {
                if ($this->playQuizView->hasChosenQuiz() && $this->quizRepository->isValidPlayableQuizId($this->playQuizView->getChosenQuiz())) {
                    $this->quizController->playQuiz($this->loginController->getId());
                }
                else {
                    $this->quizController->showAllQuizToPlay();
                }
            }

            else if ($this->resultView->didUserPressGoToShowResults() && $this->loginController->isAuthenticated()) {
                $this->quizController->showMyResults($this->loginController->getId());
            }            

            else if ($this->questionView->didUserPressToAddQuestion() && $this->loginController->isAdmin() && $this->quizRepository->isValidQuizId($this->quizView->getId())) {
                $this->questionController->addQuestion();
            }

            else if ($this->quizView->didUserPressToEditQuiz() && $this->loginController->isAdmin()) {
                $quiz = $this->quizRepository->getQuiz($this->quizView->getId());
                $this->quizController->editQuiz($quiz);
            }

            else if ($this->answerView->didUserPressToRemoveAnswers() && $this->loginController->isAdmin()) {
                $this->answerController->confirmRemoveAnswers();
            }

            else if ($this->answerView->didUserConfirmToRemoveAnswers() && $this->loginController->isAdmin()) {
                $this->answerController->removeAnswers();
            }

            else if ($this->questionView->didUserPressToEditQuestion() && $this->loginController->isAdmin()) {
                $question = $this->questionRepository->getQuestion($this->questionView->getId());
                $this->questionController->editQuestion($question);
            }

            else if ($this->questionView->didUserPressToSaveEditQuestion() && $this->loginController->isAdmin()) {
                $this->questionController->saveEditQuestion();
            }

            else if ($this->questionView->didUserPressToRemoveQuestion() && $this->loginController->isAdmin()) {
                $this->questionController->confirmRemoveQuestion();
            }

            else if ($this->questionView->didUserConfirmToRemoveQuestion() && $this->loginController->isAdmin()) {
                $this->questionController->removeQuestion();
            }

            else if ($this->quizView->didUserPressToSaveEditQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->saveEditQuiz();
            }

            else if ($this->quizView->didUserPressToRemoveQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->confirmRemoveQuiz();
            }

            else if ($this->quizView->didUserConfirmToRemoveQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->removeQuiz();
            }

            else if ($this->quizView->didUserPressGoToCreateQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->createQuiz();
            }

            else if ($this->quizView->didUserPressToShowAllQuiz() && $this->loginController->isAdmin()) {
                $this->quizController->showAllQuiz();
            }

            else if ($this->quizView->didUserPressToShowQuiz() && $this->loginController->isAdmin() && $this->quizRepository->isValidQuizId($this->quizView->getId())) {
                    $quiz = $this->quizRepository->getQuiz($this->quizView->getId());
                    $this->quizController->showQuiz($quiz);
            }

            else if ($this->questionView->didUserPressToShowQuestion() && $this->loginController->isAdmin() && $this->questionRepository->isValidQuestionId($this->questionView->getId())) {
                $this->questionController->showQuestion();
            }

            else if ($this->answerView->didUserPressToAddAnswers() && $this->loginController->isAdmin() && $this->questionRepository->isValidQuestionId($this->answerView->getId())) {
                if ($this->answerController->hasNoAnswers()) {
                    $this->answerController->addAnswers();
                }
            }

            else {
            	$this->loginController->doControll();
            }
        }
        catch (Exception $e) {
            error_log($e->getMessage() . "\n", 3, Settings::$ERROR_LOG);
            if (Settings::$DO_DEBUG) {
                throw $e;
            }
            else {
                BaseView::redirectToErrorPage();                
                die();
            }
        }		
	}
}