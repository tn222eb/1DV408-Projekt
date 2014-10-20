<?php

require_once("View/BaseView.php");

class ResultView extends BaseView {

	public function didUserPressGoToShowAllQuizToPlay() {
		if (isset($_GET[$this->showAllQuizToPlayLocation])) {
			return true;
		}
		return false;
	}
	
}