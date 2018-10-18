<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: userSessions.class.php
/////////////////////////////////////////////

//This class will allow us to deal with user sessions,
//check is a session exists, if a user is logged in and so on.

//First we define the userSessions class.
class userSessions {
	//Next we create the public static method sessionIsThere.
	//This method will check if a session exists or not.
	public static function sessionIsThere($name) {
		return (isset($_SESSION[$name])) ? true : false;
	}

	//Here we create the public static method sessionValue.
	//This method is created to return the session value.
	public static function sessionValue($name, $value) {
		return $_SESSION[$name] = $value;
	}

	//Here we create the public static method getSessionName.
	//This method is created to return the session name.
	public static function getSessionName($name) {
		return $_SESSION[$name];
	}

	//Next we create the public static method deleteToken.
	//This method is created to delete the token.
	public static function deleteSession($name) {
		//We first check if the session is there...
		if(self::sessionIsThere($name)) {
			//If is there we unset the session.
			unset($_SESSION[$name]);
		}
	}

	//Finally we create the public static method QuikMessage.
	//This method what will do is to show a message to the user,
	//until he refreshed the page, then will not be available
	//anymore.
	public static function quickMessage($name, $string = '') {
		//First we check if the session is there or exists.
		if(self::sessionIsThere($name)) {
			$session = self::getSessionName($name);
			self::deleteSession($name);
			return $session;
		} else {
			self::sessionValue($name, $string);
		}
	}
}