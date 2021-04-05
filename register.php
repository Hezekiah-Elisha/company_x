<?php
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'company_x';

  $conn = mysqli_connect($host, $username, $password, $database);

  if(mysqli_connect_errno()){
    //if there is any error with the connection, stop the script and display the error...
    exit('Failed to connect to MySQL: '. mysqli_connect_errno());
  }

  // checking if data was subbmitted
  if(!isset($_POST['username'],$_POST['password'])){
    // no data subbmitted
    exit('no data submitted');
  }

  // making sure the registration submitted are not Empty
  if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])){
    // one or more values are empty
    exit('Please complete the registration form');
  }

  if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	   exit('Password must be between 5 and 20 characters long!');
  }

  if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid!');
  }

  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	   exit('Email is not valid!');
  }

  //we need to check if the account with that username exists
  if ($stmt = $conn -> prepare('SELECT id, password FROM accounts WHERE username = ?')){
    //bind parameters
    $stmt -> bind_param('s', $POST['username']);
    $stmt -> execute();
    $stmt -> store_result();

    // store the result so we can check if the account exists
    if($stmt -> num_rows > 0){
      // username already exists
      echo "username exists, please choose another";
    }else{


      if($stmt = $conn -> prepare('INSERT INTO accounts (username, password, email) VALUES (?,?,?)')){
        // PASSWORD ENCRIPTION
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $stmt -> bind_param('sss', $_POST['username'], $password, $_POST['email'] );
        $stmt -> execute();
        echo 'You have successfully registered, you can now log in! Thank you for choosing us';

      }else{
        // something is wrong with your sql statement
        echo "Could not prepare statement";
      }
    }

    $stmt -> close();

  }else{
    echo "could not prepare statement!";
  }

  $conn -> close();

 ?>
