<?php

class QuizMessage {
    private $messageId;
    private $messages = array('Quiz har skapats', 'Quiz har tagits bort', "Quiz har ändrats");

    public function __construct($messageId){
        $this->messageId = $messageId;
    }

    public function getMessage(){
        $message = $this->messages[$this->messageId];
		$html = "<p>$message</p>";

        return $html;
    }	
}