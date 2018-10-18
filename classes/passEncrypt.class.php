<?php  
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: passEncrypt.class.php
/////////////////////////////////////////////

//This class will allow us to generate hashes and salt to encrypt the 
//passwords in the database. This class is been created purely for security purposes.

//First we define the class name passEncript.
class passEncrypt {
	//Next we create the public static function createHash.
	//First we pass a string that need to be provided and we append the salt 
	//at the beginning, i think is more secure this way.
	public static function createHash($salt = '', $string = '') {
		//Next we return using sha256 function and then we concatenate
		//$salt + $string.
		return hash('sha256', $salt . $string);
	}

	//Next we create the public static function extraSalt.
	//We pass length here.
	public static function extraSalt($length) {
		//Then we return the mcrypt_create_iv function in 
		//utf8_encode this will provide us with extra characters
		//to ensure that our salt is quite strong.
		return utf8_encode(mcrypt_create_iv($length));
	}

	//Next we create the public static function uniqueId.
	public static function uniqueId() {
		//This will return an unique hash.
		return self::createHash(uniqid());
	}	

}