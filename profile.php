<?php $page_title = "User Profile"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: profile.php
/////////////////////////////////////////////

//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}
$user_id = $_SESSION['users']; //Here we get user id.

//Here we check if there is a submitted data.
if(!empty($_POST) && isset($_POST)){
	if($_POST['submit'] == 'update_info'){
		//Next we list the variables to be sent.
		$name = $_POST['name'];
		$description = $_POST['description'];
		$is_success = $users->updateInfo($user_id, $name ,  $description); //Here we send the data to update.
		if($is_success){
			echo "<script>
 			swal('Success!','Your profile info has been updated!','success');
 		</script>";
		}else{
				echo "<script>
	 			swal('','Something went wrong. Please try again later.','warning');
	 		</script>";
		}
	}
	if($_POST['submit'] == 'profile_picture'){
		//Here we list the variables to be sent.
		if(!empty($_FILES)){
			 $is_success = $users->uploadPostPicture(); //Here we upload the photo.
			if($is_success){
				echo "<script>
	 			swal('Success!','Your profile picture has been updated!','success');
	 		</script>";
			}else{
				echo "<script>
	 			swal('','Picture is invalid. Please make sure it is in (.jpg , .png , .gif) format and not more than 2 MB size.','warning');
	 		</script>";
			}
		}

	}
}

//Here we get the user info.
date_default_timezone_set('Europe/Stockholm');
$profile = $users->getUserByID($user_id); //We get info by userid.
$name = $profile->name;
$picture_name = $profile->picture_name;
$description = $profile->user_description;
$date = date('M d, Y',strtotime($profile->date_added)); //We get the date format.
$hrs = date('H:i',strtotime($profile->date_added)); //We get the hour format.
?>

<!-- Hero Section -->
<section class="hero is-light has-text-centered">
<div class="hero-body">
  <div class="container">
    <h1 class="title">
      User Profile Page
    </h1>
    <h2 class="subtile is-size-5">
    	Hello <strong><?= ucwords($profile->name); ?>!</strong> You have been a user since: <strong><?= $date?>, <?= $hrs?> hs</strong>
    </h2>
  </div>
</div>
</section>
<br>
<main>
	<div class="container">
		<div class="box">
			<div class="column is-6 is-offset-3">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<div class="field">
					  <label class="label label is-medium">Name</label>
					  <div class="control">
					    <input name="name" class="input is-medium" type="text" value="<?= $name?>" autocomplete="off" />
					  </div>
					</div>
					<div class="field">
					  <label class="label label is-medium">Description</label>
					  <div class="control has-icons-left has-icons-right">
					  	<textarea name="description" class="textarea" type="text" value="" autocomplete="off" ><?= $description ?></textarea>
					  </div>
					</div>
					
					
					<input type="hidden" name="tokens" value="<?php echo security(formTokens::generateNewToken()); //Here we generate a new token to add more security to our form?>">
					<div class="column is-6 is-offset-3">
						<div class="column has-text-centered">
							<button class="button is-medium modal-button" type="submit" name="submit" value="update_info"><i class="fa fa-refresh fa-lg" aria-hidden="true"></i>&nbsp; Update Information</button>
						</div>
					</div>
				</form>	
				<div class="column">
					<h3 class="title is-size-4 has-text-centered">Profile Picture</h3>
				</div>
				<div class="column has-text-centered">
					<img id="profilePic" src="<?= 'images/profile/'.$picture_name ?>" alt="Profile Pic">
				</div>
				<div class="column has-text-centered">
					<p>Here you can upload a profile picture in JPEG format (max 2MB)</p>
				</div>
				<div class="column">
					<form method="post" enctype="multipart/form-data">
						<div class="field has-text-centered">
							<label class="label">Picture</label>
						</div>
						<div class="field">
							<div class="control has-text-centered">
								<input class="input is-medium inputFile" name="file" type="file">
							</div>
						</div>
						<div class="column has-text-centered">
							<button class="button is-medium modal-button" type="submit" name="submit" value="profile_picture"><i class="fa fa-upload fa-lg" aria-hidden="true"></i>&nbsp; Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>
<br>
<?php include('includes/footer.php');  ?>