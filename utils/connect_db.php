<?php

    $username = "demo";
    $password = "abc123";
    $host = "localhost";
    $dbname = "demo";


    $conn = new mysqli($host , $username , $password , $dbname);

    if($conn->connect_error){
        die("Connection failed : " . $conn->connect_error);
    }

?>