<?php

require_once("HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/CookieStorage.php");

class LoginView extends BaseView {

    private $username;
    private $password;
    private $encryptedPassword;
    private $htmlView;
    private $cookie;
    private $model;
    private $cookiePassword;
    private $message;
    private $cookieExpireTime;
    private $register = false;
    private $submitLocation = "submit";
    private $checkBoxLocation = "checkbox";
    private $registerLocation = "register";
    private $usernameLocation = "username";
    private $passwordLocation = "password";

    public function __construct() {
        $this->htmlView = new HTMLView();
        $this->model = new LoginModel();
        $this->cookie = new CookieStorage();
    }

    /**
     * @return string with html-code
     */
    public function showLoginpage() {
        $username = "";
        if (isset($_POST[$this->submitLocation]) || $this->register == true) {
            $username = $this->escape($this->username);
        }

        $html = "</br>
        <a href='?$this->registerLocation' name='$this->registerLocation'>Registrera ny användare</a>
                   <h1>MyQuiz</h1>
                    <form action=?login class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <legend>Skriv in användarnamn och lösenord</legend>
					      $this->message
					      <div class='form-group'>
					        <label class='col-sm-2 control-label' for='$this->usernameLocation'>Användarnamn: </label>
					        <div class='col-sm-10'>
					          <input id='$this->usernameLocation' class='form-control' value='$username' name='$this->usernameLocation' type='text' maxlength='30' size='20' />
					        </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->passwordLocation'>Lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='$this->passwordLocation' class='form-control' name='$this->passwordLocation' type='password' maxlength='20' size='20'>
					         </div>
					      </div>
				          <div class='form-group'>
				             <div class='col-sm-offset-2 col-sm-10'>
				               <div class='checkbox'>
				                  <label>
					              <input class='$this->checkBoxLocation' type='checkbox' name='$this->checkBoxLocation'/> Håll mig inloggad
					              </label>
					           </div>
					         </div>
					      </div>
					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='$this->submitLocation' type='submit' value='Logga in' />
					       </div>
					     </div>
					   </fieldset>
			       </form>";

        return $html;
    }

    /**
     * @return bool true uf user has pressed login else false
     */
    public function didUserPressLogin() {
        if (isset($_POST[$this->submitLocation])) {
            return true;
        }
        return false;
    }

    public function didUserPressGoToRegisterPage() {
        if (isset($_GET[$this->registerLocation])) {
            return true;
        }
        return false;
    }

    /**
     * @return bool true if user has checked remember me else false
     */
    public function userHasCheckedKeepMeLoggedIn() {
        if (isset($_POST[$this->checkBoxLocation])){
            return true;
        }
        return false;
    }

    public function getAuthentication() {
        $this->username = $_POST[$this->usernameLocation];
        $this->password = $_POST['password'];

    }

    public function setCookie(){
        if (isset($_POST[$this->checkBoxLocation])) {
            $this->cookie->save($this->usernameLocation, $this->username, $this->cookieExpireTime);
            $this->cookie->save($this->passwordLocation, $this->encryptedPassword, $this->cookieExpireTime);
        }

    }

    /**
     * @return bool true if there is cookie to load, else false
     */
    public function loadCookie() {
        if (isset($_COOKIE[$this->usernameLocation])) {
            $cookieUser = $this->cookie->load($this->usernameLocation);
            $this->cookiePassword = $this->cookie->load($this->passwordLocation);
            $this->username = $cookieUser;

            return true;
        }
        return false;
    }

    /**
     * Delete cookies
     */
    public function unsetCookies() {
        $this->cookie->save($this->usernameLocation, null, time()-1);
        $this->cookie->save($this->passwordLocation, null, time()-1);
    }

    /**
     * @param $message string message with feedback
     */
    public function setMessage($message) {
        $this->message = $message;

    }

    /**
     * @return string username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string password
     */
    public function getPassword() {
        return $this->password;
    }

    public function getEncryptedPassword() {
        return $this->encryptedPassword;
    }

    public function setEncryptedPassword($pwd) {
        $this->encryptedPassword = $pwd;

    }

    public function setDecryptedPassword($pwd) {
        $this->password = $pwd;
    }

    public function setCookieExpireTime($expireTime) {
        $this->cookieExpireTime = $expireTime;
    }

    public function getCookiePassword() {
        return $this->cookiePassword;
    }

    public function setRegister($username) {
        $this->register = true;
        $this->username = $username;
    }    
}