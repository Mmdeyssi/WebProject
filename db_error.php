<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Database Error</h1>
    <p><?php echo $err_msg; ?></p>    
</body>
</html>
<?php
$fullname=filter_input(INPUT_POST,"fullname");
$username=filter_input(INPUT_POST,"username");
$email=filter_input(INPUT_POST,"email");
$password=filter_input(INPUT_POST,"password");
$password_confirmation=filter_input(INPUT_POST,"password_confirmation");
if(empty($fullname) || empty($username) || empty($email)||empty($password)||empty($password_confirmation)){
  $err_msg="All values are not entered";
  include('db_error.php');

}


if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
  die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
  die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
  die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
  die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
  try {
    require_once "db_connect.php"; // connect to the database
    $query='INSERT INTO user(fullname, username, email, password_hash) VALUES (?,?,?,?)';
    $stm=$db->prepare($query);
    
    
    $stm->bindParam("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
    $execute_succes= $stm->execute([$fullname,$username,$email,$password_hash]);
    
    
    if(!$execute_succes){
      print_r($stm->errorInfo()[2]);
    }else{
      header("Location: login.html");
    }
    $stm->closeCursor();
    
    


  }catch(PDOException $e){
    die("query failed: " . $e->getMessage());
  }

?>
