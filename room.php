<?php $page_title = "Room"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php 
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: room.php
/////////////////////////////////////////////

//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}
$rooms = new rooms();
$room_id = (isset($_GET['ref'])) ? $_GET['ref'] : NULL;
	
//If the form was submitted update the room.
 if(!empty($_POST)){
 	$is_clean = $rooms->updateCleaning($room_id,'1');
 	if($is_clean){
 		echo "<script>
 			swal('Success!','Room has been cleaned','success');
 			setTimeout(function(){ window.location.href = 'todo.php'; },2000);
 		</script>";
 		exit;
 	}
 }

 //Here we get pending room details.
 $room_detail_raw  = $rooms->getRooms($room_id);
 if(isset($room_detail_raw[0]) && !empty($room_detail_raw)){
 	$room_detail = $room_detail_raw[0];
 	$room_id = $room_detail->room_id;
 	$room_number = $room_detail->room_number;
 	$address = $room_detail->address;
 	$name = $room_detail->name;
	$description = $room_detail->description;
	$last_update = ucwords($room_detail->name);
	$date = date('M d, Y',strtotime($room_detail->date_added_updated));
	$hrs = date('H:i',strtotime($room_detail->date_added_updated));
 }else{
 	header('Location: todo.php');
 	exit;
 }
?>

<!-- Hero Section -->
<section class="hero is-light">
	<div class="hero-body">
	  <div class="container">
	    <h1 class="title has-text-centered is-size-5-mobile">
	      This room needs to be cleaned...
	    </h1>
	    <h2 class="subtile has-text-centered is-size-5">
	      If your work is done, please change the status to clean!
	    </h2>
	  </div>
	</div>
</section>
<br>
<div class="container">
	<div class="box">
		<div class="column">
			<a class="button is-danger is-fullwidth">
				ROOM NEEDS TO BE CLEANED
			</a>
		</div>
		<div class="column">
			<h1 class="title">
				<i class="fa fa-bed fa-lg" aria-hidden="true"></i>&nbsp; <?= $room_number ?> - <?= $address?>
			</h1>
		</div>
		<div class="column">
			<p class="subtitle"><strong>Last update by: </strong><?=ucwords($name)?></p>
		</div>
		<div class="column">
			<p class="subtitle"><strong>Time: </strong><?=$date?> at <?=$hrs?> hs</p>
		</div>
		<div class="column">
			<p class="subtitle"><strong>Description</strong></p>
		</div>
		<div class="column">
			<div class="box">
				<div class="column">
					<?= $description ?>
				</div>
			</div>
		</div>
		<div class="column">
			<form name="change_status" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				<button class="button is-success is-large mobile-is-medium" name="change_status" value="clean" type="submit">
					Change Status To Clean
				</button>
			</form>
		</div>
	</div>
</div>
<br>
<?php include('includes/footer.php');  ?>