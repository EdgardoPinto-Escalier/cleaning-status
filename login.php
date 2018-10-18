<?php $page_title = "Login"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: login.php
/////////////////////////////////////////////

if(userSessions::sessionIsThere('Logout')) {
	echo userSessions::quickMessage('Logout');
}

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
               userSessions::quickMessage('Login', '<script type="text/javascript">swal({title: "Success!",text:  "You are now logged in...",type:  "success",timer: 2000,showConfirmButton: false});</script>');

               //Finally we redirect to index.php using the pageRedirection/isGoingTo method. 
               if($users->isEmployee()){
               pageRedirection::isGoingTo('todo.php');

               }else{
                pageRedirection::isGoingTo('index.php'); 
                
               }

            //Otherwise we show the error message we have for the login.
            }else {
               echo "<script type='text/javascript'>swal({title: 'Oops!',text: 'You have entered an invalid Username and/or Password...',type: 'error',timer: 2000,showConfirmButton: false});</script>";
            }
        }
    }
}
?>

<!-- Hero Section -->
<section class="hero is-light has-text-centered">
<div class="hero-body">
  <div class="container">
    <h1 class="title">
      User Login
    </h1>
    <h2 class="subtile is-size-5">
      Login here if you already have an existing account on this web platform
    </h2>
  </div>
</div>
</section>
<br>

	<div class="container">
		<div class="box">
			<div class="column is-6 is-offset-3">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<div class="field">
					  <label class="label label is-medium">Username</label>
					  <div class="control has-icons-left has-icons-right">
					    <input name="username" class="input is-medium" value="<?php echo security(userInput::getItem('username')); ?>" placeholder="Type your Username here..." type="text" autocomplete="off" required>
					    <span class="icon is-small is-left">
					      <i class="fa fa-user-secret"></i>
					    </span>
					  </div>
					</div>
					<div class="field">
					  <label class="label label is-medium">Password</label>
					  <div class="control has-icons-left has-icons-right">
					    <input name="password" class="input is-medium" placeholder="Type your password here..." type="password" autocomplete="off" required>
					    <span class="icon is-small is-left">
					      <i class="fa fa-key"></i>
					    </span>
					  </div>
					</div>
					<div class="columns">
						<div class="column">
							
						</div>
					</div>	
					<input type="hidden" name="tokens" value="<?php echo security(formTokens::generateNewToken()); //Here we generate a new token to add more security to our form?>">
					<div class="column is-6 is-offset-3">	
						<div class="column has-text-centered">
							<button class="button is-medium modal-button" type="submit" name="login" ><i class="fa fa-sign-in fa-lg" aria-hidden="true"></i>&nbsp; Login User</button>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>
<br>
<?php include('includes/footer.php');  ?>