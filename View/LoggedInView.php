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

    public function __construct() {
        $this->model = new LoginModel();
    }

    /**
     * @return string with html
     */
    public function showLoggedInPage() {
        $this->username = $this->model->getUsername();

        if ($this->model->isAdmin()) {
            $this->menu .= "<li><a name='" . $this->showAllQuizLocation . "' href='?" . $this->showAllQuizLocation . "'>Visa alla quiz</a></li>";
        }

        $html = "</br> </br>
            <h4>$this->username är inloggad</h4>    
            <nav class='navbar navbar-default' role='navigation'>
            <div class='navbar-header'>
              <button type='button' class='navbar-toggle' data-toggle='collapse' 
                 data-target='#example-navbar-collapse'>
                 <span class='sr-only'>Toggle navigation</span>
                 <span class='icon-bar'></span>
                 <span class='icon-bar'></span>
                 <span class='icon-bar'></span>
              </button>
              <a class='navbar-brand'>MyQuiz</a>
           </div>
           <div class='collapse navbar-collapse' id='example-navbar-collapse'>
              <ul class='nav navbar-nav'>
                 <li><a name='Play' href='?". $this->showAllQuizToPlayLocation . "'>Välj quiz att spela</a></li>
                 <li><a name='" . $this->showResultsLocation . "' href='?" . $this->showResultsLocation . "'>Visa mina resultat</a></li>
                 $this->menu
                 <li><a name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a></li>
              </ul>
           </div>
        </nav>
        $this->message";
        return $html;
    }
 
    /**
     * @return bool true if user has pressed log out else false
     */
    public function didUserPressLogOut() {
        if (isset($_GET[$this->logOutLocation])) {
            return true;
        }
        return false;

    }

    /**
     * @param $message string containing feedback
     */
    public function setMessage($message) {
        $this->message = $message;
    }
}