<?php 

class QuizModel {
	
	private $quiz = array(
		'Basket' => array(
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
		        'Question' => 'Vem vann NBA MVP 2009',
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

	   		4 => array(
		    	'Question' => 'Vilket lag spelar LeBron James nuvarande för',
		    	'Answers' => array(
		    		'A' => 'Miami Heat',
		    		'B' => 'Cleveland Cavaliers',
		    	),
		    	'CorrectAnswer' => 'B'
		    ),    
		    
	   		5 => array(
		    	'Question' => 'Vem hade högst poängsnitt i NBA 2009',
		    	'Answers' => array(
		    		'A' => 'Dwyane Wade',
		    		'B' => 'LeBron James',
		    		'C' => 'Kobe Bryant',
		    		'D' => 'Kevin Durant',
		    		'E' => 'Carmelo Anthony'
		    	),
		    	'CorrectAnswer' => 'A'
		    ),   
	    ),
			
		'Mat' => array(	
		    1 => array(
		        'Question' => 'Vad står KFC för',
		        'Answers' => array(
		            'A' => 'Kentucky Fried Chicken',
		            'B' => 'Kansas Fried Chicken',
		            'C' => 'Kent Fried Chicken'
		        ),
		        'CorrectAnswer' => 'A'
		    ),

		    2 => array(
		        'Question' => 'Vad är inte nötkött',
		        'Answers' => array(
		            'A' => 'Entrecote',
		            'B' => 'Ryggbiff',
		            'C' => 'Högrev'
		        ),
		        'CorrectAnswer' => 'A'
		    ),
	    ),
	);

	public function getAllQuiz() {
		$arrayOfQuizNames = array();

		foreach($this->quiz as $quizName => $value) {
			$arrayOfQuizNames[] = $quizName;
		}
		return $arrayOfQuizNames;
	}

	public function getQuiz($quizName) {
		return $this->quiz[$quizName];
	}

	public function countQuiz($quizName) {
		return count($this->quiz[$quizName]);
	}

	public function validateQuiz($userAnswers, $quizName) {
		$score = 0;

		foreach ($this->quiz[$quizName] as $questionNr => $value) {
			if (isset($userAnswers[$questionNr]) == true) {
				if ($userAnswers[$questionNr] == $value['CorrectAnswer']) {
					$score++;
				}
			}
		}
		return $score;
	}
}