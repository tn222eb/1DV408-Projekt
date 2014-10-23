<?php

class ValidateInput {

	/**
  	* Validate length of string
  	*
  	* @param string input of user
  	*
  	* @return bool true or false based on length
  	*/		
	public function validateLength($string) {
		if (mb_strlen($string) < 3 || empty($string)) {
			return false;
		}
		return true;		
	}

	/**
  	* Check if string has illegal chars
  	*
  	* @param string input of user
  	*
  	* @return bool true or false based on if string is illegal
  	*/	
	public function validateCharacters($string) {
		if($string != strip_tags($string)) {
			return false;
		}
		return true;
	}	
}