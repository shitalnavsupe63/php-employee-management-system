<?php

$servername = 'localhost';

$username = 'root';

$password = 'shital@2003';

$dbname = 'employee-system';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("connection failed : ".$conn->connect_error);
}


?>