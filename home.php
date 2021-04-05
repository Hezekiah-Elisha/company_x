<?php
  // we need to use session
  session_start();

  //if the user is not logged in is redirected to the login page...
  if(!isset($_SESSION['loggedin'])){
    header('Location:index.html');
    exit;
  }

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Home Page</title>
     <link rel="stylesheet" href="style.css">
   </head>
   <body class="loggedin">
     <nav class="navtop">
       <div class="">
         <h1>The tech archlight</h1>
         <a href="profile.php">Profile</a>
         <a href="logout.php">Logout</a>
       </div>
     </nav>
     <div class="content">
       <h2>Home Page</h2>
       <p>Welcome back, <?=$_SESSION['name']?>!</p>
     </div>
   </body>
 </html>
