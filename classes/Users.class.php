<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: Users.class.php
/////////////////////////////////////////////

//This class will allow us to login/logout/find users, we will
//use this class along with dbConnection class to check user info.

//First we define the class name here.
class users {
	//Next we set some private properties to be used later.
	private $_db,
			$_userData,
			$_sessionName,
	        $_isLoggedIn;

	//Here we create the constructor object of the class.
	public function __construct($user = null) {
		$this->_db = dbConnection::getInstance();
		//Here we assign to the variable _sessionName the path to the session.
		//This way we can use it later.
		$this->_sessionName = config::getPath('session/session_name');
		//If not user (we do this just to check current user login data)
		if(!$user) {
			//First we check if the user is really logged in...
			if(userSessions::sessionIsThere($this->_sessionName)) {
				//If the session exists then we assign it to the variable user.
				$user = userSessions::getSessionName($this->_sessionName);

				//Find the user data.
				if($this->findUsers($user)) {
					//Then we confirm that is really logged in so we set it to true.
					$this->_isLoggedIn = true;
				//Oterwise...	
				}else {
					//We redirect to login.php.
					pageRedirection::isGoingTo('login.php');
				}
			}
		  //Oterwise, if the user has been defined....
		} else {
			$this->find($user);
		}
	}


	//Here we create the createNewUser method.
	public function createNewUsers($fields = array()) {
		//If this createNewUsers method does not work....
		if(!$this->_db->insertData('users', $fields)) {
			//We throw an exception with the message.
			throw new Exception(' Something went wrong with your account creation process...');
		}
	}


	//Here we delete the users. 
	public function deleteUser($user) {
		$query = "DELETE from users WHERE id='".$user['id']."'";

		if(!$this->_db->dbQuery($query)) {
			//We throw an exception with the message.
			throw new Exception(' Something went wrong with your user deletion process...');
		}else{
			echo true;
		}
		
	}


	//Here we create the createNewPost method.
	public function createNewPost($fields = array()) {
		//If this createNewUsers method does not work....
		if(!$this->_db->insertData('posts', $fields)) {
			//We throw an exception with the message.
			throw new Exception(' Something went wrong with your blog post creation process...');
		}
	}


	//Next we create the findUser method.
	//This method will be in charge to find the users, in the database.
	public function findUsers($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			//Here we create a variable called newData, this will represent the data 
			//we get from the table. So then we use the getData method to find in 
			//the database the users table where the fiels is equal to user.
			$newData = $this->_db->getData('users', array($field, '=', $user));
			//Now we use the dbCount method to count the users. This means yes
			//there are users in the database.
			if($newData->dbCount()) {
				//Here we create a variable called _userData and store in it the first 
				//user result in the database using the firstResult method.
				$this->_userData = $newData->firstResult();
				//Then we return true.
				return true;
			}
		}
		return false;
	}


	//Next we create the loginUser method.
	//This method will be in charge to login previously registered users, in the site.
	//We start by passing the username and password and setting them to null by default.
public function loginUser($username = null, $password = null) {
		//Here we check if the user exist or not. Here we use the findUsers method.
		$user = $this->findUsers($username);

		
		if($user) {
			//Next we check the password and extra_salt using the createHash method in the passEncrypt class.
			if($this->data()->password === passEncrypt::createHash($password, $this->data()->extra_salt)) {
			  //Next we set the user session, define the session name and store the user's id.
			  userSessions::sessionValue($this->_sessionName, $this->data()->id); 
			  userSessions::sessionValue('user_role', $this->data()->role); 
			  //Here we return true to confirm that this has been a successful login.
			  return true;         
        	} 
        }
        return false;
    }
    

    //Next we create the logoutUser method.
	//This method will be in charge to logout a user, in the site.
    public function logoutUser() {
    	userSessions::deleteSession($this->_sessionName);
    }

   	//Next we create the public data method.
	//This method will just return _userData.
	public function data() {
		return $this->_userData;
	}

	//Next we create the public isLoggedIn method.
	//This method will help us to see if the user is logged in or not.
	public function isLoggedIn() {
		return $this->_isLoggedIn;
	} 


	//Here we get the user info using username and return that information.
	public function getUser($username = ""){
		$sql = "SELECT * from users where username='".$username."'";
		$query = $this->_db->dbQuery($sql);
		$get_results = $query->dbResults();
		if(!empty($get_results)) {
			return $get_results[0];
		}
	}


	//Here we get the user info using user id and return that information.
	public function getUserByID($user_id = ""){
		$sql = "SELECT * from users where id='".$user_id."'";
		$query = $this->_db->dbQuery($sql);
		$get_results = $query->dbResults();
		if(!empty($get_results)) {
			return $get_results[0];
		}
	}

	//Here we check if user is employee.
	public function isEmployee($redirect = false){
		$user_role = $_SESSION['user_role'];
		$is_employee = false;

		if($user_role == 'Employee'){ //If equals return true;
			$is_employee = true;
		}

		//Here if flag redirect is true redirect the page to employee todo.
		if($redirect && $is_employee){
               pageRedirection::isGoingTo('todo.php'); exit;
		}

		//else return the query
		return $is_employee;
		
	}

		//Here we pdate the userInfo.
	public function updateInfo($user_id,$name , $description = ""){
		$query = "UPDATE users set 
		name='".$name."' , user_description = '".$description."'  WHERE id='".$user_id."'";

		//Here we check if successful.
		if(!$this->_db->dbQuery($query)) {
			//We throw an exception with the message.
			throw new Exception('Something went wrong with your update of info');
		}else{
			return true;
		}
	}

		//Here we pdate the profile picture.
	public function updateProfilePic($file_name){
		$user_id = $_SESSION['users'];
		$query = "UPDATE users set 
		picture_name='".$file_name."'  WHERE id='".$user_id."'";

		//Then we check if successful.
		if(!$this->_db->dbQuery($query)) {
			//We throw an exception with the message.
			throw new Exception('Something went wrong with your update of info');
		}else{
			return true;
		}
	}


	public function uploadPostPicture() {
		$error = array();

		// First we specify all the extension formats allowed.
		if(isset($_FILES["file"])){
			$allowedExtensions = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			// Here we use the end function to grab the extension format and putted into a variable $extension.
			$extension = strtolower(end($temp));

			$user_id = $_SESSION['users'];

			$_FILES['file']['name'] = $user_id.'.'.$extension;
			// echo "<pre>",print_r($_FILES),"</pre>";die();
			
			// Next with this if statement we check if all the extension formats are valid.
			// echo $extension;die();
			if ((($_FILES["file"]["type"] == "image/gif")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/jpg")
					|| ($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/x-png")
					|| ($_FILES["file"]["type"] == "image/png"))
					// Here we check that the images are less then 3mb.
					&& ($_FILES["file"]["size"] < 2000000)
					&& in_array($extension, $allowedExtensions)
					) {
				// Another if statement to check in case of error redirect to register.php along with the error message.
				if ($_FILES["file"]["error"] > 0) {
					echo 'Error'. $_FILES["file"]["error"] . '<br/>';
				} else {
					
						// Here we use the move_uploaded_file function to move all uploaded avatars to the right folder.
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"images/profile/" . $_FILES["file"]["name"]);

						
						
						// update the profile picture
						$this->updateProfilePic($_FILES["file"]["name"]);
						// If everything goes ok we return true.
						return true;
					
				}
				
			} else {
				// If there is any problems we store an invalid message.
				$error[] = '<p>Invalid file type...</p>';
			}
		}

		if(!empty($error)){
			return false;
		}
	}


	// delete user
	public function deleteUserAccount($user_id) {
			$query = "DELETE from users WHERE id='".$user_id."'";

			if(!$this->_db->dbQuery($query)) {
				//We throw an exception with the message.
				throw new Exception(' Something went wrong with your account creation process...');
			}else{
				return true;
			}
			
	}

	//check user exist
	public function checkUserExists($name = NULL){
		// if has name check it
		if(!empty($name)){
			$sql = "SELECT * from users where  LOWER(name) = '".strtolower($name)."'";	
		}
		$query = $this->_db->dbQuery($sql);
		$get_results = $query->dbResults();
		if(!empty($get_results)) {
			return true;
		}else{
			return false;
		}
	}

}


