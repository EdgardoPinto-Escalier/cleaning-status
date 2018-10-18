<?php include('core/pageTitle.php'); //Here we include the pageTitle.php file.?>
<!DOCTYPE html>
<!--////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: header.php
////////////////////////////////////////////////-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $site_title . $divider . $page_title; ?></title>
    <meta name="Description" content="Cleaning Status is an online web platform to check cleaning status of a hotel rooms.">
    <meta name="Keywords" content="Clean, Room, Status, Web Platform, Web App, Hotel">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script type="text/javascript" src="dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">

    <!-- Favicon section -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/manifest.json">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

<?php
    $users = new Users();//Here we instantiate the user object class.
    $isEmployee =$users->isEmployee(); //Here we check if is employee.
  if($isEmployee){  //Here we switch hompage depending the role of the user (employee or admin).
    $homepage = 'todo.php';
   }else{
    $homepage = 'index.php';
   }
?>  

  </head>
  <body class="site">
   <main class="site-content">
    <section>
    <div class="container">
    
      <nav class="navbar" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="<?= $homepage?>">
            <img src="images/logo.png" alt="logo" width="112" height="28">
          </a>

          <button class="button navbar-burger is-flex-touch" data-target="navMenu"> 
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>  
        <div class="navbar-menu" id="navMenu">
          <div class="navbar-start">
          <?php if($users->isLoggedIn()) : //If user is logged in show Home Welcome, logout user and About me pages?>
            <!-- navbar items -->
            <a href="<?= $homepage ?>" class="navbar-item"><i class="fa fa-home fa-lg" aria-hidden="true"></i>&nbsp;Home</a>
            <?php if(!$isEmployee) { ?>
            <a href="rooms.php" class="navbar-item"><i class="fa fa-bed fa-lg" aria-hidden="true"></i>&nbsp;Hotel Rooms</a>
            <a href="todo.php" class="navbar-item"><i class="fa fa-list-ul fa-lg" aria-hidden="true"></i>&nbsp;To Do</a>
            <?php } ?>
          </div>

          <div class="navbar-end">
            <!-- navbar items -->
            <?php if(!$isEmployee) { ?>
            <a href="users.php" class="navbar-item"><i class="fa fa-user fa-lg" aria-hidden="true"></i>&nbsp; Users</a>
            <a href="register.php" class="navbar-item"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; Register</a>
            <?php } ?>
            <a href="profile.php" class="navbar-item"><i class="fa fa-wrench fa-lg" aria-hidden="true"></i>&nbsp; User Settings</a>
            <a href="logout.php" class="navbar-item"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>&nbsp; Logout</a>
            <?php else : //Otherwise just show Login and Register Account in the menu bar?>
            <a href="index.php" class="navbar-item"><i class="fa fa-home fa-lg" aria-hidden="true"></i>&nbsp; Home</a>
            <?php endif;?>
          </div>
        </div>   
      </nav>
    </div>
  </section>
