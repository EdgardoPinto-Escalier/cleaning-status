<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: init.php
/////////////////////////////////////////////

//This file will be included in every page and will help us 
//to autoload classes, start the sessions and have config settings.


// The first thing we do is to start the session.
session_start();

//Next we create an array of different config settings.
$GLOBALS['config'] = array(
   'mysql' => array(
		'host' => 'localhost',
		'username' => '< YOUR DATABASE USERNAME GOES HERE >',
		'password' => '< YOUR DATABASE PASSWORD GOES HERE >',
		'db' => '< YOUR DATABASE NAME GOES HERE >'
	),
	'session' => array(
		'session_name' => 'users',
		'tokens_name' =>  'tokens'
	)
);

//Here we autoload the classes using the __autoload function.
function __autoload($class_name){
	//Here for normal file inclusion check if file exists to avoid errors.
	if(file_exists('classes/'.$class_name . '.class.php')){
		require_once('classes/'.$class_name . '.class.php');
	}
	//Here for the ajax file calls check if file exists to avoid errors.
	if(file_exists('../classes/'.$class_name . '.class.php')){
		require_once('../classes/'.$class_name . '.class.php');
	}
}

//Finally we require the security.php file.
//Here for normal file call inclusion check if file exists to avoid errors.
if(file_exists("security/security.php")){
require_once "security/security.php";
}
//Here for the ajax file calls check if file exists to avoid errors.
if(file_exists("../security/security.php")){
require_once "../security/security.php";

}