<?php $page_title = "Home"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: index.php
/////////////////////////////////////////////

//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}
$users->isEmployee(true); //Here we redirect to the employee page if the user is an employee.

//If user is logged in we show the Success you are logged in message.
if(userSessions::sessionIsThere('Login')) {
      echo userSessions::quickMessage('Login');
   } 
   
 $rooms = new rooms();
 $room_list = $rooms->getRooms(); //We get all rooms available.
 $all_rooms = $clean_rooms = $pending_rooms= 0 ;
 //We get room count for cleaned.
if(isset($rooms->getRoomsStatCount('1')[0])){
 $clean_rooms = count($rooms->getRoomsStatCount('1'));
}
 //We get room count for pending.
if(isset($rooms->getRoomsStatCount('0')[0])){
 $pending_rooms = count($rooms->getRoomsStatCount('0'));
}
 //We get room count for all_rooms.
 $all_rooms = count($room_list);
 $user_id = $_SESSION['users']; // get user id
//We check if there is a submitted data.
if(!empty($_POST) && isset($_POST)){
  if($_POST['submit'] == 'update_info'){
    //We list the variables to be send.
    $name = $_POST['name'];
    $is_success = $users->updateInfo($user_id, $name ,  $description); // send the data  to update
  }
}

//Here we get User info.
date_default_timezone_set('Europe/Stockholm'); //We set the correct timezone first.
$profile = $users->getUserByID($user_id); //We get info by userid.
$name = $profile->name;
$date = date('M d, Y',strtotime($profile->date_added)); //Get the date format.
$hrs = date('H:i',strtotime($profile->date_added)); //Get the hour format.
?>

  <!-- Hero Section -->
  <section class="hero is-light">
    <div class="hero-body">
      <div class="container">
        <h1 class="title has-text-centered">
          Cleaning Status
        </h1>
        <h2 class="subtile has-text-centered is-size-5">
        Welcome Admin: <strong><?= ucwords($profile->name); ?></strong> this is the current status of the rooms now: <strong><?php echo date('M d, Y'); ?></strong> at <strong><?php echo date('H:i'); ?></strong> hs
        </h2>
      </div>
    </div>
  </section>
  <br>
  <!-- Columns Section -->
  <div class="container">
    <div class="box">
      <div class="columns">
        <div class="column">
          <div class="card">
            <div class="card-content has-text-centered">
            <i class="fa fa-bed fa-3x" aria-hidden="true"></i>
            <p class="title" id="stat_rooms"><?=$all_rooms?></p>
            <p class="subtitle">Number of rooms</p>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card">
            <div class="card-content has-text-centered">
              <i class="fa fa-check-square-o fa-3x" aria-hidden="true"></i>
              <p class="title" id="stat_room_cleaned"><?=$clean_rooms?></p>
              <p class="subtitle">Rooms already cleaned</p>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card">
            <div class="card-content has-text-centered">
              <i class="fa fa-refresh fa-3x" aria-hidden="true"></i>
              <p class="title" id="stat_room_toclean"><?=$pending_rooms?></p>
              <p class="subtitle">Rooms left to clean</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section -->  
      <table class="table is-bordered is-fullwidth is-hoverable">
        <thead>
          <tr>
            <th class="title has-text-centered is-size-5-mobile"><i class="fa fa-bed is-hidden-mobile" aria-hidden="true"></i>&nbsp; Room #</th>
            <th class="title has-text-centered is-size-5-mobile"><i class="fa fa-map-marker is-hidden-mobile" aria-hidden="true"></i>&nbsp; Address</th>
            <th class="title has-text-centered is-size-5-mobile"><i class="fa fa-question-circle-o is-hidden-mobile" aria-hidden="true"></i>&nbsp; Status</th>
          </tr>
        </thead>
        <tbody>

        <?php if(!empty( $room_list)) {  //We check if has rooms.
          foreach($room_list as $room){ //We loop through each rooms and proceed with display.
            $room_number = $room->room_number;
            $address = $room->address;
            $status = ($room->status == '0') ? 'Pending' : 'Cleaned';
            $room_id = $room->room_id;
            $description = $room->description;
            $last_update = ucwords($room->name);
            $date = date('M d, Y',strtotime($room->date_added_updated));
            $hrs = date('H:i',strtotime($room->date_added_updated));
        ?>

          <tr ref="<?=$room_id?>">
            <td class="has-text-centered"><strong id="room_num"><?=$room_number?></strong></td>
              <td class="has-text-centered" id="address"><?=$address?></td>
              <td class="has-text-centered" id="status"><label id="stat_desc"><?=$status?></label> &nbsp;<a href="#"><i class="fa fa-pencil-square-o fa-lg modal-button view_stat" ref="<?=$room_id?>" aria-hidden="true"></i></a>
              <input type="hidden" id="desc" value="<?=$description?>">
              <input type="hidden" id="stat" value="<?=$room->status?>">
              <input type="hidden" id="last_update" value="<?=$last_update?>">
              <input type="hidden" id="date" value="<?=$date?>">
              <input type="hidden" id="hrs" value="<?=$hrs?>">
            </td>
          </tr>
          <?php  
            }
          } ?>
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
      <p class="modal-card-title is-size-5-mobile"><i class="fa fa-bed fa-lg is-hidden-mobile" aria-hidden="true"></i><strong>&nbsp; Room: 742 - 104 E. Main ST. PA</strong></p>
      <button class="delete modal-button is-hidden-mobile" data-target="#modal" aria-label="Afaste"></button>
    </header>
    <section class="modal-card-body">
      <div class="tile">
        <div class="tile is-12 is-parent">
          <article class="tile is-child box">
            <p class="title">Task</p>
            <p class="subtitle">Description</p>
            <div class="description column">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.</div>
          </article>
        </div>
      </div>
      <div class="column">
        <p class="subtitle"><strong><i class="fa fa-hourglass-half" aria-hidden="true"></i>&nbsp; Status: </strong> <label id="stat">Clean</label></p>
      </div>
      <div class="column">
        <p><em>Updated by: <label id="updated_by">John Thomson</label> on <label id="update_date">October 19 2017</label> at <label id="update_hrs"> 20:53</label> hs</em></p>
      </div>
      <div class="column"> 
        <form>
         <label id="status">
           Cleaning Performed
           <input id="cleaning_performed" name="cleaning_performed" checked="" onchange="" type="checkbox">
         </label> 
        </form> 
      </div>
    </section>
    <footer class="modal-card-foot">
        <button class="button modal-button" data-target="#modal">&nbsp;Close</button>
    </footer>
  </div>
</div>
<?php include('includes/footer.php');  ?>