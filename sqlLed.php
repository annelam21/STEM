<!DOCTYPE html>
<html>

<head>
    <title>
        GPIO LED
    </title>
</head>

<body style="text-align:center;">

    <h1 style="color:green;">
        GPIO LED Control
    </h1>

    <?php
        //Use an if statement to trigger php functions
        if (array_key_exists('offButton', $_POST)) {  //listen for button press
            offButton(); 
        } 
        else if (array_key_exists('onButton', $_POST)) { 
            onButton(); 
        } 
        
        //Define our php functions
        function offButton() { //turns off led
            $servername = "localhost"; //use localhost because file is already on the server
            $username = "root";
            $password = "guzzo";
            $dbname = "gpioControl"; //database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "UPDATE led SET toggleOne=1"; //update value to turn off the led
            $result = $conn->query($sql); //holds result of the query

            //Tell user if sql query failed
            if ($conn->query($sql) === TRUE) {
                echo "LED off". "<br>";
            }
            else {
                echo "Error: " .$sql . "<br>" . $conn->error;
            }

            //Close connection
            $conn->close(); 
        }
            
        function onButton() { //turns on led
            $servername = "localhost"; //use localhost because file is already on the server
            $username = "root";
            $password = "guzzo";
            $dbname = "gpioControl"; //database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "UPDATE led SET toggleOne=2 "; //update value to turn on the led
            $result = $conn->query($sql); //holds result of the query

            //Tell user if sql query failed
            if ($conn->query($sql) === TRUE) {
                echo "LED on". "<br>";
            }
            else {
                echo "Error: " .$sql . "<br>" . $conn->error;
            }

            //Close connection
            $conn->close(); 
        }  
    ?>

    <!-- Use a form to automatically execute our php functions -->
    <form method="post">
        <input type="submit" value="Off" class="button" name="offButton" />

        <input type="submit" value="On" class="button" name="onButton" />
    </form>

</body>

</html>