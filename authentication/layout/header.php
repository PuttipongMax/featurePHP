<?php
  include "config.php";
  session_start();
  $authenticated = false;
  if(isset($_SESSION['email'])){
    $authenticated = true;
    // echo $_SESSION['first_name'];
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="../authentication/index.php">
          <img  
            src="<?php echo $base_url; ?>/images/ghost.png" 
            class="mb-2" width="24" height="24"
          />
          Best Store
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-dark" aria-current="page" href="#">Home</a>
            </li>
          </ul>

          <?php
          if($authenticated) {
          ?>
      
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Admin
              </a>
              <ul class="dropdown-menu">
                <li><a class="btn" href="<?php echo $base_url; ?>/profile.php">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo $base_url; ?>/logout.php">Logout</a></li>
              </ul>
            </li>  
          </ul>

          <?php
          }else{
          ?>

          <ul class="navbar-nav">
            <li><a class="btn btn-outline-primary me-2" href="<?php echo $base_url; ?>/register.php">Register</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="btn btn-primary" href="<?php echo $base_url; ?>/login.php">Login</a></li>
          </ul>
      
          <?php
            }
          ?>

        </div>
      </div>
    </nav>
    