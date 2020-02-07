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

    $sql = "SELECT * FROM students"; //select everything
    $result = $conn->query($sql); //holds result of the query

    if ($result->num_rows > 0) { //check if the result contains anything
        // output data of each row
        while($row = $result->fetch_assoc()) { //make a "row" variable equal to result->fetch_assoc(), an arrary
            echo "name: " . $row["name"]. " - Age: " . $row["age"]. " Grade Level: " . $row["gradeLevel"]. "<br><br>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
?>