<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: config.class.php
/////////////////////////////////////////////

//This class gives the flexibility to access all the different configuration
//values in the website. 

class config {
	public static function getPath($myPath = null) {
		if($myPath) {
			$config = $GLOBALS['config'];
			$myPath = explode('/', $myPath);
			//Here with the foreach loop we loop through each element of this array.
			foreach($myPath as $myPathPart) {
				if(isset($config[$myPathPart])) {
					$config = $config[$myPathPart];
				}
			}
			return $config;
		}
		return false;
	}
}