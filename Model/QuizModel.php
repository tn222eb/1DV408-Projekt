<?php 

class QuizModel {
	
	private $questions = array(
	    1 => array(
	        'Question' => 'Vad står NBA för',
	        'Answers' => array(
	            'A' => 'National Basketball Association',
	            'B' => 'National Baseball Assocation',
	            'C' => 'National Bowling Association'
	        ),
	        'CorrectAnswer' => 'A'
	    ),

	    2 => array(
	        'Question' => 'Vem vann MVP 2009',
	        'Answers' => array(
	            'A' => 'Kobe Bryant',
	            'B' => 'Dwyane Wade',
	            'C' => 'Lebron James'
	        ),
	        'CorrectAnswer' => 'C'
	    ),

	    3 => array(
	    	'Question' => 'Vem vann NBA Finals MVP 2014',
	    	'Answers' => array(
	    		'A' => 'LeBron James',
	    		'B' => 'Tim Duncan',
	    		'C' => 'Kawhi Leonard'
	    	),
	    	'CorrectAnswer' => 'C'
	    ),
	    
	);

	public function getQuestions() {
		return $this->questions;
	}

}