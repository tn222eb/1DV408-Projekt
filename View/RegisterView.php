<?php

class RegisterView {

	private $usernameLocation = "username";
	private $passwordLocation = "password";
	private $confirmPasswordLocation = "confirmpassword";
	private $registerLocation = 'register';
	private $loginLocation = 'login';
	private $message;

    public function setMessage($message){
        $this->message .= $message;
    }	

	public function didUserPressReturnToLoginPage() {
		if (isset($_GET[$this->loginLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressSubmit() {
		if (isset($_POST[$this->registerLocation])) {
			return true;
		}
		return false;
	}

	public function getUserName() {
		if (isset($_POST[$this->usernameLocation])) {
			return $_POST[$this->usernameLocation];
		}
	}

	public function getPassword() {
		if (isset($_POST[$this->passwordLocation])) {
			return $_POST[$this->passwordLocation];
		}

	}

	public function getConfirmPassword() {
		if (isset($_POST[$this->confirmPasswordLocation])) {
			return $_POST[$this->confirmPasswordLocation];
		}
	}

	public function showRegisterPage() {
        $username = "";
        if(isset($_POST[$this->registerLocation])){
            $usernameInput = $this->getUserName();
            $username .= strip_tags($usernameInput);
        }

		$html = "
		</br>
		<a href='?$this->loginLocation'>Tillbaka</a>
			   <h1>MyQuiz</h1>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <legend>Registrera ny användare</legend>
					      $this->message
					      <div class='form-group'>
					        <label class='col-sm-2 control-label' for='$this->usernameLocation'>Användarnamn: </label>
					        <div class='col-sm-10'>
					          <input id='username' class='form-control' value='$username' name='$this->usernameLocation' type='text' size='20' maxlength='20'/>
					        </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->passwordLocation'>Lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password' class='form-control' name='$this->passwordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->confirmPasswordLocation'>Repetera Lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password2' class='form-control' name='$this->confirmPasswordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>
					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='$this->registerLocation' type='submit' value='Registrera' />
					       </div>
					     </div>
					   </fieldset>
			       </form>
		";

		return $html;
	}
}
