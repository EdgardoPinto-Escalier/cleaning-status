<?php include('core/init.php'); // Here we include the init.php file.?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: ajax_delete_user.php
/////////////////////////////////////////////

//Here on this file we hold the code to delete users from the users.php page

//Here we check the post values via ajax.
if(isset($_POST) && !empty($_POST)){
	$user_id = $_POST['ref'];
	$users = new Users; //Here we call the users class where the function for deleting is located.
	$is_deleted = $users->deleteUserAccount($user_id); //Here we call the delete function.


	//If success return success message, else return false success message
	if($is_deleted){
		echo json_encode(array('success'=>true,'msg'=>''));
	}else{
		echo json_encode(array('success'=>false,'msg'=>''));
	}
}
?>