<?php $page_title = "Register"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: register.php
/////////////////////////////////////////////

//If user has left any input in the form...
if(userInput::isThere()) {
   if(formTokens::verifyToken(userInput::getItem('tokens'))) {
     //We create a new instance of the class.
     $validations = new formValidations();
     //Here we verify post and create an array, this new array
     //will have all the rules included in the formValidations class.
     $validate = $validations->verify($_POST, array(
         //Next we include the 4 fields we want to validate.
         //Each of this fields will have their own array with the rules
         //for each field.
         'name' => array(
               'required' => true,             //name is required.                           
               'minValue' => 3,                //Minimun characters allowed 3. 
               'maxValue' => 50                //Max characters allowed 50.
         ),
         'username' => array(
               'required' => true,             //username is required.
               'minValue' => 2,                //Minimun characters allowed 2.
               'maxValue' => 20,               //Max characters allowed 20.
               'uniqueName' => 'users'         //We want this to be unique to the users table.
         ),
         'password' => array(
               'required' => true,             //password is required.
               'minValue' => 7                 //Minimun characters allowed 7.
         )  
      ));

     //If validations passed then..
     if($validations->passedRule()) {
         //We create a new instance of the users class.
         $users = new Users();
         //We declare extraSalt here.
         $extraSalt = passEncrypt::extraSalt(32);
         //We use a try block to see if there are not errors.
         try {
         
            if(!$users->checkUserExists(userInput::getItem('name'))) {
               $users->createNewUsers(array(
                  'name'            => userInput::getItem('name'),
                  'username'        => userInput::getItem('username'),
                  'password'        => passEncrypt::createHash(userInput::getItem('password'), $extraSalt),
                  'role'            => userInput::getItem('role'),
                  'extra_salt'      => $extraSalt
                  ));
                  
                       userSessions::quickMessage('newAccount', '<script> swal({title: "New Account Created", text: "The new login credentials are ready to use", type: "success",timer: 2000, showConfirmButton: false}); </script>');
                       pageRedirection::isGoingTo('users.php');
            }else{
                userSessions::quickMessage('newAccount', '<script> swal({title: "Failed!", text: "User already exists.", type: "warning",timer: 2000, showConfirmButton: false}); </script>');
            } 
         } catch(Exception $e) {
            die($e->getMessage());
         }
          
         //Otherwise if validations don't pass....
         } else {
            //We create a foreach loop and we go trough every error
            //and output them one by one using a list item tag.
           echo "<script>";             
         foreach($validations->errorList() as $error) {
            echo $error . ";";                       
         }
         echo "</script>";       
      }
   }
}
$users->isEmployee(true); //Here we redirect to employee page if the user is an employee.
?>

<!-- Hero Section -->
<section class="hero is-light has-text-centered">
<div class="hero-body">
  <div class="container">
    <h1 class="title">
      New User Registration
    </h1>
    <h2 class="subtile is-size-5">
      Here you can register new user roles for the web platform (Admin and Employees)
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
					  <label class="label label is-medium">Full Name</label>
					  <div class="control has-icons-left has-icons-right">
					    <input name="name" class="input is-medium" placeholder="Type your full name here..." type="text" value="<?php echo security(userInput::getItem('name')); ?>" autocomplete="off" />
					    <span class="icon is-small is-left">
					      <i class="fa fa-user"></i>
					    </span>
					  </div>
					</div>
					<div class="field">
					  <label class="label label is-medium">Username</label>
					  <div class="control has-icons-left has-icons-right">
					    <input name="username" class="input is-medium" placeholder="Type your Username here..." type="text" value="<?php echo security(userInput::getItem('username')); ?>" autocomplete="off" />
					    <span class="icon is-small is-left">
					      <i class="fa fa-user-secret"></i>
					    </span>
					  </div>
					</div>
					<div class="field">
					  <label class="label label is-medium">Password</label>
					  <div class="control has-icons-left has-icons-right">
					    <input name="password" class="input is-medium" placeholder="Type your password here..." type="password" autocomplete="off" />
					    <span class="icon is-small is-left">
					      <i class="fa fa-key"></i>
					    </span>
					  </div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="control">
                <div class="select">
                  <select name="role">
                    <option value="Administrator">Administrator</option>
                    <option value="Employee">Employee</option>
                  </select>
                </div>
							</div>
						</div>
						<div class="column">
						</div>	
					</div>
					<input type="hidden" name="tokens" value="<?php echo security(formTokens::generateNewToken()); //Here we generate a new token to add more security to our form?>">
					<div class="column is-6 is-offset-3">
						<div class="column has-text-centered">
							<button class="button is-medium modal-button" type="submit" name="register"><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>&nbsp; Register User</button>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>
</main>
<br>
<?php include('includes/footer.php');  ?>