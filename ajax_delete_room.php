<?php include('core/init.php'); // Here we include the init.php file.?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: ajax_delete_room.php
/////////////////////////////////////////////

//Here on this file we hold the code to delete rooms from the rooms.php page

//Here we check post values via ajax.
if(isset($_POST) && !empty($_POST)){
	//Here we get user logged in.
	$user_id = $_SESSION['users'];
	 //Here we get the room id.
	$room_id = $_POST['ref'];
	$rooms = new rooms; //Here we call the room class where the function for deleting is located.
	$is_deleted = $rooms->deleteRoom($room_id); //Here we call the delete function.
	//If success return success message  else return false success
	if($is_deleted){
		echo json_encode(array('success'=>true,'msg'=>''));
	}else{
		echo json_encode(array('success'=>false,'msg'=>''));
	}
}
?>