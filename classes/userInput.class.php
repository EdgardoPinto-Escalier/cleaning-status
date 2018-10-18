<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: userInput.class.php
/////////////////////////////////////////////

//This takes care of all the input from the users.

class userInput {
	//First we create the function isThere to check if any input 
	//or data is actually there on the form.
	public static function isThere($type = 'post') {
		//Next we switch $type and check some cases.
		switch($type) {
			case 'post';
				return (!empty($_POST)) ? true : false;
			break;
			case 'get';
				return (!empty($_GET)) ? true : false;
			break;
			default;
				return false;
			break;
		}
	}

	public static function getItem($item) {
		//Here we check for post data/item first...
		if(isset($_POST[$item])) {
			//If its available we'll return that item.
			return $_POST[$item];
		//Otherwise if there is any get data/item...
		} else if(isset($_GET[$item])) {
			//We return that item.
			return $_GET[$item];
	}
	//By default we return an empty string so in case of no
	//results at all we still want to return something back.
	return '';
	}
}