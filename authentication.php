<?php

  session_start();

  // change this to your connection info
  $host = 'localhost';
  $database_username = 'root';
  $database_password = '';
  $database = 'company_x';

  $conn = mysqli_connect($host, $database_username, $database_password, $database);

  if(mysqli_connect_errno()){
    //if there is any error with the connection, stop the script and display the error...
    exit('Failed to connect to MySQL: '. mysqli_connect_errno());
  }

  // checking if data was subbmitted
  if(!isset($_POST['username'], $_POST['password'])){
    // could not get data subbmitted
    exit('Please fill both the username and password fields!');
  }

  // prepare our sql, preparing the sql statement will prevent sql injection
  if($stmt = $conn -> prepare('SELECT id, password FROM accounts WHERE username = ?')){
    // bind parameters
    $stmt -> bind_param('s', $_POST['username']);
    $stmt -> execute();
    // store_result so we can check if the account exists
    $stmt -> store_result();

    if($stmt -> num_rows > 0){
      $stmt -> bind_result($id, $password);
      $stmt -> fetch();

      // account exists, now we verify the password
      if(password_verify($_POST['password'], $password)){
        //verification successful!
        //create sessions so we know the user is logged in
        session_regenerate_id();

        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;

        header('Location: home.php');

      }else{
        // insorrect password
        echo "incorrect password";
      }

    }else{
      echo "Incorrect username or password";
    }

    $stmt -> close();
  }

 ?>
