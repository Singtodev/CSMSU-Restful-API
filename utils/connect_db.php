<?php

    $username = "demo";
    $password = "abc123";
    $host = "localhost";
    $dbname = "book_member";


    $conn = new mysqli($host , $username , $password , $dbname);

    if($conn->connect_error){
        die("Connection failed : " . $conn->connect_error);
    }

?>