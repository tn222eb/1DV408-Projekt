<?php

class QuizMessage {
    private $messageId;
    private $messages = array('Quiz har skapats', 'Quiz har tagits bort', "Quiz har ändrats", "Fråga har lagts till", "Svar har lagts till", "Quiz finns redan", "Quiz måste minst ha 3 tecken", "Quiz får inte innehålla ogiltiga tecken", "Frågan måste ha minst 3 tecken", "Frågan får inte innehålla ogiltiga tecken", "Frågan finns redan", "Måste bocka i rätt svar", "Svars alternativ måste vara minst 3 tecken", "Svars alternativ får inte innehålla ogiltiga tecken");

    public function __construct($messageId){
        $this->messageId = $messageId;
    }

    public function getMessage(){
        $message = $this->messages[$this->messageId];
		$html = "<p>$message</p>";

        return $html;
    }	
}