<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: updatecleaning.php
/////////////////////////////////////////////

 $users = new Users();
//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}

//If user is logged in we show the Success you are logged in message.
if(userSessions::sessionIsThere('Login')) {
      echo userSessions::quickMessage('Login');
}

//Here we update the cleaning.
if(!empty($_POST['ref']) && !empty($_POST['status'])){
	$status = $_POST['status'];
	$ref = $_POST['ref'];
	//If true it means the status is clean, else its pending.
	if($status == 'true'){
		$stat = '1';
	}else{
		$stat = '0';
	}
	 $rooms = new rooms();
	 $room_list = $rooms->updateCleaning($ref,$stat); //Here we update the room with the clean status.
	 //If success return a success message.
	 if($room_list){
	 	$response = json_encode(array('success'=>1,'msg'=>''));
	 }else{
	 	$response = json_encode(array('success'=>0,'msg'=>''));
	 }

	 echo $response;
}
?>