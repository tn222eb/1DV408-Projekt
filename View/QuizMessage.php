<?php

class QuizMessage {
    
    private $messageId;
    private $messages = array('Quiz har skapats', 'Quiz har tagits bort', "Quiz har ändrats", "Fråga har lagts till", "Svar har lagts till", "Quiz namn finns redan", "Quiz namn måste minst ha 3 tecken", "Quiz namn får inte innehålla ogiltiga tecken", "Fråga måste ha minst 3 tecken", "Fråga får inte innehålla ogiltiga tecken", "Fråga finns redan", "Måste bocka i rätt svar", "Alla svars alternativ måste ha minst 3 tecken", "Inga svars alternativ får inte innehålla ogiltiga tecken");

    public function __construct($messageId){
        $this->messageId = $messageId;
    }

    public function getMessage(){
        $message = $this->messages[$this->messageId];
		$html = "<p>$message</p>";

        return $html;
    }	
}