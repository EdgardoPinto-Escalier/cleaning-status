<?php include('core/init.php'); // Here we include the init.php file.?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: ajax_add_rooms.php
/////////////////////////////////////////////

//Here on this file we hold the code to add rooms from the rooms.php page modal.

//Here we check post values from adding the form via ajax.
if(isset($_POST) && !empty($_POST)){

	//Here we get user logged in.
	$user_id = $_SESSION['users'];

	 //Here we prepare the array to be inserted.
	$room_info = array('room_number' => $_POST['room_number'] , 'address' => $_POST['address'],'user_id'=>$user_id);
	$rooms = new rooms; //Here we call the room class where the function for adding is located.
	
	$check_if_exist = $rooms->checkRoomExist($_POST['room_number'],$_POST['address']);

	if(!$check_if_exist){
        	$is_added = $rooms->createNewRoom($room_info); //Here we call create new room.

         	//If success returns a success message else return false message.
        	if($is_added){
	        	echo json_encode(array('success'=>true,'msg'=>'','data'=>$is_added));
        	}else{
	        	echo json_encode(array('success'=>false,'msg'=>''));
	}	    
	        }else{
	    	    echo json_encode(array('success'=>false,'msg'=>'Room number and address already exists.'));
	}
}
?>