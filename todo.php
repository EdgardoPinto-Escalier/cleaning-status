<?php $page_title = "To Do"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: todo.php
/////////////////////////////////////////////

$rooms = new rooms();
//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}

//Here we get pending rooms.
$pending_rooms  = $rooms->getRoomsStatCount('0');
$ctr_pending_rooms = count($pending_rooms);
$user_id = $_SESSION['users']; //Here we get user id.

//Here we check if there is a submitted data.
if(!empty($_POST) && isset($_POST)){
  if($_POST['submit'] == 'update_info'){
    //Next we list the variables to be sent.
    $name = $_POST['name'];
    $is_success = $users->updateInfo($user_id, $name ,  $description); //Here we send the data to update.
  }
}

//Next we get the User info.
date_default_timezone_set('Europe/Stockholm');
$profile = $users->getUserByID($user_id); //We get info by userid.
$name = $profile->name;
$date = date('M d, Y',strtotime($profile->date_added)); //We get the date format.
$hrs = date('H:i',strtotime($profile->date_added)); //We get the hour format.
?>

<!-- Hero Section -->
<section class="hero is-light has-text-centered">
<div class="hero-body">
  <div class="container">
    <h1 class="title">
      Rooms Pending To Clean
    </h1>
    <h2 class="subtile is-size-5">
      Hello <strong><?= ucwords($profile->name); ?></strong> this are the current rooms that needs to be cleaned now: <strong><?php echo date('M d, Y'); ?></strong> at <strong><?php echo date('H:i'); ?></strong> hs
    </h2>
  </div>
</div>
</section>
<br>
<div class="container">
	<div class="box has-text-centered">
		<?php 
		//Next we check if empty if not get the room info.
		if(!empty($pending_rooms)){ 
			foreach($pending_rooms as $room){
				if(count($pending_rooms) == 0){
					$ctr_pending_rooms =  0 ;
					continue;
				}
		?>

		<div class="columns">
		    <div class="column">
        		<a href="<?= 'room.php?ref='.$room->room_id ?>" class="is-size-6-mobile button is-danger is-outlined is-large is-fullwidth">
        			<i class="fa fa-bed fa-lg is-hidden-mobile" aria-hidden="true"></i>&nbsp; Room # <?= $room->room_number ?> - Address: <?= $room->address ?>
        		</a>
    		</div>
		</div>
		<?php }
			}
		 ?>
		<div class="column">
			<p class="subtitle">There are <strong><?=$ctr_pending_rooms?></strong> rooms left to clean.</p>
		</div>
	</div>	
</div>
<br>
<?php include('includes/footer.php');  ?>