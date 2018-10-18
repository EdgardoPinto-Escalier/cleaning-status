<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: security.php
/////////////////////////////////////////////

//This is a very small function that what it does is to,
//take a string, use the htmlentities php function to escape 
//a string then will use the ENT_QUOTES to escape single and
//double quotes and finally will define the character encoding
//making it a bit more secure.

function security($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}