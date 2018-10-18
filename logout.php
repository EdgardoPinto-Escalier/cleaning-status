<?php require('core/init.php'); // Here we include the init.php file.?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: logout.php
/////////////////////////////////////////////

//First we instantiate the users object class.
$users = new Users();
//Here we use the logoutUser method.
$users->logoutUser();
 userSessions::quickMessage('Logout', '<script>swal({title: "Logout!",text: "You have been successfuly logged out!",type: "info",timer: 2000,showConfirmButton: false});</script>');

//Finally we redirect to login.php
pageRedirection::isGoingTo('login.php');





