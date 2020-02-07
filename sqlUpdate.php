<?php
    $servername = "localhost"; //use localhost because file is already on the server
    $username = "user";
    $password = "password";
    $dbname = "school"; //database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE students SET age=7, gradeLevel=2 WHERE name='Carl' ";
    $result = $conn->query($sql); //holds result of the query

    if ($conn->query($sql) === TRUE) {
        echo "Record successfully updated";
    }
    else {
        echo "Error: " .$sql . "<br>" . $conn->error;
    }

    $conn->close();
?>