<?php $page_title = "Rooms"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: rooms.php
/////////////////////////////////////////////

//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}
$users->isEmployee(true); //Here we redirect to employee page if the user is an employee.
//If user has left any input in the form...
if (userInput::isThere()) {
    if (formTokens::verifyToken(userInput::getItem('tokens'))) {
        //We create a new instance of the class.
        $validations = new formValidations();
        //Here we verify post and create an array, this new array
        //will have all the rules included in the formValidations class.
        $validate    = $validations->verify($_POST, array(
            //Next we include the 2 fields we want to validate.
            //Each of this fields will have their own array with the rules
            //for each field, in this case will be only required = true.
            'username' => array(
                'required' => true
            ),
            'password' => array(
                'required' => true
            )
        ));

        //If validation passes the we login the user.
        if($validate->passedRule()) {
            //First we create a new instance of the user object here.
            $users = new Users();
            //Then what we do is to use a login variable and we use the users object/loginUser method
            //created in the users class and passing the userInput/getItem username and password.
            $login = $users->loginUser(userInput::getItem('username'), userInput::getItem('password'));
            //Next with this if statement we check first if the login was successfull...
            if($login){
               //If was, then we show a success message using the userSessions/quickMessage method.
               userSessions::quickMessage('Login', '<script type="text/javascript">swal({title: "Success!",text:  "You are now logged in...",type:  "success",timer: 3000,showConfirmButton: false});</script>');

               //Finally we redirect to index.php using the pageRedirection/isGoingTo method. 
               pageRedirection::isGoingTo('index.php'); 
            //Otherwise we show the error message we have for the login.
            }else {
               echo "<script type='text/javascript'>swal({title: 'Oops!',text: 'You have entered an invalid Username and/or Password...',type: 'error',timer: 3000,showConfirmButton: false});</script>";
            }
        }
    }
}

$rooms = new rooms();
$room_list = $rooms->getRooms(); //Here we get all rooms available.
?>

<!-- Hero Section -->
<section class="hero is-light">
<div class="hero-body">
  <div class="container">
    <h1 class="title has-text-centered is-size-5-mobile">
      Hotel Room Administration Panel
    </h1>
    <h2 class="subtile has-text-centered is-size-5">
      Here you can add edit or erase the rooms available in the web platform
    </h2>
  </div>
</div>
</section>
<br>
<div class="container">
	<div class="box">
		<div class="column">
			<a class="button is-medium modal-button"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; Add New Room</a>
		</div>
		<br>
		<!-- Table Section -->
      <table class="table is-bordered is-fullwidth is-hoverable" id="rooms_tbl">
        <thead>
          <tr>
            <th class="title has-text-centered is-size-5-mobile"><i class="fa fa-bed is-hidden-mobile" aria-hidden="true"></i>&nbsp; Room #</th>
            <th class="title has-text-centered is-size-5-mobile"><i class="fa fa-map-marker is-hidden-mobile" aria-hidden="true"></i>&nbsp; Address</th>
            <th class="title has-text-centered is-size-5-mobile"><i class="fa fa-pencil-square-o is-hidden-mobile" aria-hidden="true"></i>&nbsp; Edit/Delete</th>
          </tr>
        </thead>
        <tbody>
        <?php if(!empty( $room_list)) {  //Here we check if has rooms.
            foreach($room_list as $room){ //Here we loop through each rooms and proceed with display.
              $room_number = $room->room_number;
              $address = $room->address;
              $status = ($room->status == '0') ? 'Pending' : 'Cleaned';
              $room_id = $room->room_id;
              $description = $room->description;
              $last_update = ucwords($room->name);
              $date = date('M d, Y',strtotime($room->date_added_updated)); //We get the date.
              $hrs = date('H:i',strtotime($room->date_added_updated)); //We get the time.
          ?>
          <tr ref="<?=$room_id?>">
            <td class="has-text-centered"><strong><?= $room_number?></strong></td>
            <td class="has-text-centered"><?= $address?></td>
            <td class="has-text-centered"><a href="<?= 'editroom.php?ref='.$room_id?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>&nbsp; <a href="#" class="delete_a" ref="<?=$room_id?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
          </tr>
          <?php }} ?>
        </tbody>
      </table>
	</div>
</div>
<br>

<!-- Modal -->
<div class="modal" id="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title"><i class="fa fa-bed fa-lg" aria-hidden="true"></i><strong>&nbsp; New Room</strong></p>
      <button class="delete modal-button" data-target="#modal" aria-label="Afaste"></button>
    </header>
    <section class="modal-card-body">
      <div class="column"> 
        <form class="" method="post" name="add_new_room" action="rooms.php">
         <div class="field">
		  <label class="label">Room Number</label>
		  <div class="control">
		    <input class="input" name="room_number" type="text" placeholder="e.g Room 152">
		  </div>
		</div>
		<div class="field">
		  <label class="label">Address</label>
		  <div class="control">
		    <input class="input" name="address" type="text" placeholder="e.g Canal Street 255">
		  </div>
		</div>
        </form> 
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button " id="add_new_room" data-target="#modal"><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp; Add New Room</button>
    </footer>
  </div>
</div>
<?php include('includes/footer.php');  ?>