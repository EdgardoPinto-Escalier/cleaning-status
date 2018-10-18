<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: pageRedirections.class.php
///////////////////////////////////////////// 

//This function will take care of the redirections or future redirections
//in the site so we don't have to use the header function all the time, 
//when a redirection is needed.

class pageRedirection {
	public static function isGoingTo($location = null) {
		if($location) {
			header('Location: ' . $location);
		} 
	}
}