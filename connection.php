<?php

//Create  a POP connection (Procedural)

//Variable declarations

$servername ="localhost";
$username = "root";
$password = "";
$db_name = "my_database";

//Create a Connection

$conn = new mysqli($servername,$username,$password,$db_name);

//Check Connection

if (!$conn) {
         die ("Connection Failed!!:" . mysqli_connect_error());
} else {
     //  echo "Connection Successful!!";
        
}
?>