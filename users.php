<?php $page_title = "Users"; //This is the page title assigned to the variable $page_title to be used in the title in header.php ?>
<?php include('core/init.php'); // Here we include the init.php file.?>
<?php include('core/pageTitle.php'); // Here we include the pageTitle.php file.?>
<?php include('includes/header.php'); //Here we include the header.php file?>
<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: users.php
/////////////////////////////////////////////

//Small check to see if user is logged in or not.
//If user is not logged in redirect to login.php
if(!$users->isLoggedIn()){
   pageRedirection::isGoingTo('login.php');
}
if(userSessions::sessionIsThere('newAccount')) {
    echo userSessions::quickMessage('newAccount');
}
?>

<!-- Hero Section -->
<section class="hero is-light has-text-centered">
<div class="hero-body">
  <div class="container">
    <h1 class="title">
      Registered users
    </h1>
    <h2 class="subtile is-size-5">
      This are the current list of users registered on the web platform (Admin and Employees)
    </h2>
  </div>
</div>
</section>
<br>
<div class="container">
	<div class="box">
		<br>
		<!-- Table Section -->
      <table class="table is-bordered is-fullwidth is-hoverable is-narrow is-mobile">
        <thead>
          <tr>
            <th class="title has-text-centered is-size-6-mobile"><i class="fa fa-user-circle is-hidden-mobile" aria-hidden="true"></i>&nbsp; Name</th>
            <th class="title has-text-centered is-size-6-mobile"> <i class="fa fa-user-secret is-hidden-mobile" aria-hidden="true"></i>&nbsp; User Name</th>
            <th class="title has-text-centered is-size-6-mobile"><i class="fa fa-male is-hidden-mobile" aria-hidden="true"></i>&nbsp; Role</th>
            <th class="title has-text-centered is-size-6-mobile"><i class="fa fa-window-close-o is-hidden-mobile" aria-hidden="true"></i>&nbsp; Erase</th>
          </tr>
        </thead>
        <tbody>

        <?php
        //Here we get all posts from an specific user. 
          $users = dbConnection::getInstance()->dbQuery("SELECT * FROM users");
          //Then we loop through each record and show the record in each line.
          foreach($users->dbResults() as $users){
            $users->name;
            $users->username;
            $users->role;
            echo "<tr ref='$users->id'>";
            echo "<td class='has-text-centered'>{$users->name}</td>";
            echo "<td class='has-text-centered'>{$users->username}</td>";
            echo "<td class='has-text-centered'>{$users->role}</td>";
            echo "<td class='has-text-centered'><button class='button delete_users is-outlined' ref='{$users->id}'><a href='#' class='delete_users' ref='{$users->id}'><i class='fa fa-window-close' aria-hidden='true'></i>&nbsp; <span>Erase</span></a></button></td>";
            echo "</tr>";
          }
         ?>
       </tbody>
      </table>
	</div>
</div>
<?php include('includes/footer.php');  ?>