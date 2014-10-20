<?php

require_once("./View/LoginView.php");
require_once("./Model/LoginModel.php");
require_once("View/BaseView.php");

class LoggedInView extends BaseView {
    private $model;
    private $message;
    private $username;
    private $menu;
    private $adminNavigation;

    public function __construct(){
        $this->model = new LoginModel();
    }

    /**
     * @return string with html
     */
    public function showLoggedInPage(){
        $this->username = $this->model->getUsername();

        if ($this->model->isAdmin()) {
            $this->menu .= "<a class='btn btn-default' name='" . $this->showAllQuizLocation . "' href='?" . $this->showAllQuizLocation . "'>Visa alla quiz</a> </br>
            ";
        }

        $html = "
            <h1>MyQuiz</h1>
            <H3>$this->username är inloggad</H3>
            $this->message
            <a class='btn btn-default' name='Play' href='?". $this->showAllQuizToPlayLocation . "'>Välj quiz att spela</a>
            </br>
             <a class='btn btn-default' name='" . $this->showResultsLocation . "' href='?" . $this->showResultsLocation . "'>Visa mina resultat</a>  
             </br>
            $this->menu
            <a class='btn btn-default' name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a>
    ";
        return $html;
    }
 
    /**
     * @return bool true if user has pressed log out else false
     */
    public function didUserPressLogOut(){
        if(isset($_GET[$this->logOutLocation])){
            return true;
        }
        return false;

    }

    /**
     * @param $message string containing feedback
     */
    public function setMessage($message){
        $this->message = $message;
    }
}