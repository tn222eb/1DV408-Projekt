<?php

class LoginMessage {
    private $messageId;
    private $messages = array('Användarnamn saknas', 'Lösenord saknas', "Felaktigt användarnamn och/eller lösenord",
                              "Felaktig information i cookie", 'Användarnamnet innehåller ogiltiga tecken',
                              'Användarnamnet är upptaget', 'Lösenorden matchar inte', 'Lösenorden har få tecken. Minst 6 tecken',
                              'Användarnamnet har för få tecken. Minst 3 tecken',
                              "Inloggningen lyckades och vi kommer komma ihåg dig nästa gång", "Inloggningen lyckades", "Du är nu utloggad",
                              'Registrering av ny användare lyckades', "Inloggning lyckades via cookies"
    );

    public function __construct($messageId) {
        $this->messageId = $messageId;
    }

    /**
     * @return string html with feedback
     */
    public function getMessage() {
        $message = $this->messages[$this->messageId];

        if($this->messageId < 9) {
            $alert = "<div class='alert alert-danger alert-error'>";
        }   
        else{
            $alert = "<div class='alert alert-success'>";
        }
        if(!empty($message)) {
          $ret = "
          $alert
          <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					<p>$message</p>
					</div>";
        }
        else {
            $ret = "<p>$message</p>";
        }
        return $ret;
    }
}