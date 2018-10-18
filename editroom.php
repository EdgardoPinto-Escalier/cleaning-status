<?php $page_title = "Edit Room"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: editroom.php
/////////////////////////////////////////////

//Here we edit the rooms information in the editroom.php page.

$rooms = new rooms();
$room_id = (isset($_GET['ref'])) ? $_GET['ref'] : NULL;
	
//If the form was submitted update the room.
 if(!empty($_POST)){
 	$room_number = $_POST['room_number'];
 	$address = $_POST['address'];
 	$description = $_POST['description'];
 	$is_updated = $rooms->updateRoomInfo($room_id,$room_number,$address,$description);
    echo "<script>
 			swal('Success!','The room information has been updated','success');
 			setTimeout(function(){ window.location.href = 'rooms.php'; },1500);
 		</script>"; 
 	exit;
 }
 //Next we get pending room details.
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
<section class="hero is-light has-text-centered">
<div class="hero-body">
  <div class="container">
    <h1 class="title">
      Edit Hotel Room
    </h1>
    <h2 class="subtile">
      Use the form below to make changes to an existent Hotel Room
    </h2>
  </div>
</div>
</section>
<br>
<main>
	<div class="container">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<div class="box">
				<div class="column is-6 is-offset-3">
					<div class="field">
					  <label class="label">Number</label>
					  <div class="control">
					    <input class="input" type="text" name="room_number" value="<?=$room_number?>">
					  </div>
					</div>
					<div class="field">
					  <label class="label">Address</label>
					  <div class="control">
					    <input class="input" type="text" name="address" value="<?=$address ?>">
					  </div>
					</div>
				</div>
				<div class="column is-6 is-offset-3">
					<div class="field">
					  <label class="label">Description</label>
					  <div class="control">
					    <textarea id="desription" name="description" class="textarea" placeholder="Description..."><?=$description ?></textarea>
					  </div>
					</div>
					<div class="column has-text-centered">
						<button class="button is-medium" type="submit" value="save_info"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i>&nbsp; Save Changes</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</main>
<br>
<!-- CKEditor form -->
<script>
    CKEDITOR.replace( 'description' );
</script>
<?php include('includes/footer.php');  ?>