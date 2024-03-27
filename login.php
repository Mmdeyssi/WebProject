<?php

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $mysqli = require __DIR__ . "/db_connect.php";
    $sql=sprintf("SELECT * FROM user WHERE email='%s'", $mysqli->real_escape_string($_POST["email"]));
    $result=$mysqli->query($sql);
    $user=$result->fetch_assoc();
    
    if($user){
        if(password_verify($_POST["password"],$user["password"])){
            session_start();
            header( "Location: index.html" ); 

        }
    }

}
