<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: rooms.class.php
/////////////////////////////////////////////

//This class will allow us to list/check status/update/create/delete rooms, we will
//use this class along with dbConnection class to check rooms info.

//First we define the class name here. EXTENDS THE USER FUNCTION TO CHECK IF USER IS LOGGED IN
class rooms extends Users{
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

			
					$this->_isLoggedIn = true;
				//Oterwise...	
			}else {
					//We redirect to login.php.
					pageRedirection::isGoingTo('login.php');
			}
		  //Oterwise, if the user has been defined....
		} else {
			$this->find($user);
		}
	}


	//Here we get the list of rooms and its details.
	public function getRooms($room_id = NULL){
		//If has NO room id GET ALL.
		if(empty($room_id)){
			$sql = "SELECT rooms.*,	`users`.name from rooms LEFT JOIN users  on `rooms`.user_id = `users`.id";	
		}else{ //Else set a filter.
			$sql = "SELECT rooms.*,	`users`.name from rooms LEFT JOIN users  on `rooms`.user_id = `users`.id where `rooms`.room_id = '".$room_id."'";	
		}
		$query = $this->_db->dbQuery($sql);
		$get_results = $query->dbResults();
		if(!empty($get_results)) {
			return $get_results;
		}
	}

	//Here we give a number to the status of the rooms.
	public function getRoomsStatCount($status = '0'){
		$sql = "SELECT `rooms`.* from rooms WHERE status='".$status."' group by rooms.room_id";
		$query = $this->_db->dbQuery($sql);
		$get_results = $query->dbResults();
		if(!empty($get_results)) {
			return $get_results;
		}
	}

	//Here we update the ref and the status of cleaning in each room.
	public function updateCleaning($ref,$status){
		$user_id = $_SESSION['users']; //Get logged in user.
		$query = "UPDATE rooms set 
		status='".$status."' , user_id = '".$user_id."'  WHERE room_id='".$ref."'";
		if(!$this->_db->dbQuery($query)) {
			//We throw an exception with the message.
			throw new Exception('Something went wrong with your update cleaning');
		}else{
			return true;
		}
	}

	//Here we create the createNewRoom method to create new rooms.
	public function createNewRoom($fields = array()) {
		//If this createNewRoom method does not work....
		$newRoomID = $this->_db->insertData('rooms', $fields);

		if(!$newRoomID) {
			//We throw an exception with the message.
			throw new Exception(' Something went wrong with your account creation process...');
		}else{
			$newRoomID= $this->getLastInserted();
			return $newRoomID;
		}
	}

	//Here we get the last inserted room.
	public function getLastInserted(){
		//If has NO room id GET ALL.
		$sql = "SELECT room_id from rooms order by room_id desc limit 1";	
		
		$query = $this->_db->dbQuery($sql);

		$get_results = $query->dbResults();

		if(!empty($get_results)) {
			$id  = $get_results[0]->room_id;
			return $id;
		}
	}

	//Here we delete the room.
	public function deleteRoom($room_id) {
			$query = "DELETE from rooms WHERE room_id='".$room_id."'";

			if(!$this->_db->dbQuery($query)) {
				//We throw an exception with the message.
				throw new Exception(' Something went wrong with your account creation process...');
			}else{
				return true;
			}
			
	}

	//Here we update the room info.
	public function updateRoomInfo($room_id,$room_number,$room_address,$description){
		$user_id = $_SESSION['users']; //Get logged in user.
		$query = "UPDATE rooms set 
		user_id = '".$user_id."' , room_number = '".$room_number."', address = '".$room_address."', description = '".$description."'  WHERE room_id='".$room_id."'";
		if(!$this->_db->dbQuery($query)) {
			//We throw an exception with the message.
			throw new Exception('Something went wrong with your update cleaning');
		}else{
			return true;
		}
	}

	//check list of rooms and details 
	public function checkRoomExist($room_number = NULL,$address=NULL){
		// if has NO room id GET ALL
		if(!empty($room_number)){
			$sql = "SELECT * from rooms where `rooms`.room_number ='".$room_number."' AND LOWER(`rooms`.address) = '".strtolower($address)."'";	
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


