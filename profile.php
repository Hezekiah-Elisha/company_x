<?php
  session_start();

  if(!isset($_SESSION['loggedin'])){
    header('Location : index.html');
    exit;
  }

  $host = 'localhost';
  $database_username = 'root';
  $database_password = '';
  $database = 'company_x';

  $conn = mysqli_connect($host, $database_username, $database_password, $database);

  if(mysqli_connect_errno()){
    //if there is any error with the connection, stop the script and display the error...
    exit('Failed to connect to MySQL: '. mysqli_connect_errno());
  }

  // fetch from database info
  $stmt = $conn -> prepare('SELECT password, email FROM accounts WHERE id = ?');

  $stmt -> bind_param('i', $_SESSION['id']);
  $stmt -> execute();
  $stmt -> bind_result($password, $email);
  $stmt -> fetch();
  $stmt -> close();
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Profile Info</title>
   </head>
   <body class="loggedin">
     <nav class="navtop">
       <div class="">
         <h1>The Tech Archlight</h1>
         <a href="home.php">Home</a>
         <a href="logout.php">Logout</a>
       </div>
     </nav>
     <div class="content">
       <h2>Profile Page</h2>
       <div class="">
         <p>Your Account details are below:</p>
         <table>
           <tr>
             <th>UserName: </th>
             <td><?=$_SESSION['name']  ?></td>
           </tr>
           <tr>
             <th>Password :</th>
             <td><?=$password ?></td>
           </tr>
           <tr>
             <th>Email :</th>
             <td><?=$email ?></td>
           </tr>
         </table>
       </div>
     </div>
   </body>
 </html>
