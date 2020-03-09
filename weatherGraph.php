<html>

<head>
    <title>DHT</title>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto Slab', serif;
        }
        #chartContainer {
            width: 80%;
            height: 370px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div id="chartContainer"></div>
    <br>
    <hr>
    <br>

    <?php
        //Create arrays to store humidity and temperature
        $dataHum = array();
        $dataTemp = array();

        //Store highest & lowest data
        $highestHum = 0;
        $highHumTime;
        $lowestHum = 9999;
        $lowHumTime;
        $highestTemp = 0;
        $highTempTime;
        $lowestTemp = 9999;
        $lowTempTime;
        
        //Store time
        $lastRecordTime;
        $currentTime;
        
        //Credentials
        $servername = "192.168.0.200";
        $username = "humid";
        $password = "raspberry";
        $dbname = "gpioControl";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM DHT ORDER BY id DESC"; //order by to grab most recent records first
        $result = $conn->query($sql); //holds result of the query

        if ($result->num_rows > 0) { //check if the result contains anything
            // output data of each row
            while($row = $result->fetch_assoc()) { //make a "row" variable equal to result->fetch_assoc(), an array
                //save humidity temp and time in variables
                $hum = $row["humidity"];
                $temp = $row["temperature"];
                $timeStamp = $row["time"];

                //check if current data is highest/lowest
                if ($hum > $highestHum) {
                    $highestHum = $hum;
                    $highHumTime = $timeStamp;
                }
                elseif ($hum < $lowestHum) {
                    $lowestHum = $hum;
                    $lowHumTime = $timeStamp;
                }
                if ($temp > $highestTemp) {
                    $highestTemp = $temp;
                    $highTempTime = $timeStamp;
                }
                elseif ($temp < $lowestTemp) {
                    $lowestTemp = $temp;
                    $lowTempTime = $timeStamp;
                }

                //convert timestamp to only show month date and time
                $convertToUnix = strtotime($timeStamp);
                $convertedTime = date("M. d H:i:s", $convertToUnix);
                
                //save hum and temp in an associative array
                $humPoint = ["y" => $hum, "label" => $convertedTime];
                $tempPoint = ["y" => $temp, "label" => $convertedTime];
                
                //push the associative arrays into beginning of arrays
                array_unshift($dataHum, $humPoint);
                array_unshift($dataTemp, $tempPoint);
            }
        }
        else {
            echo "0 results";
        }

        //Convert time to human readable format
        $unixHighHumTime = strtotime($highHumTime);
        $convHighHumTime = date("M. d, Y H:i:s", $unixHighHumTime);
        
        $unixLowHumTime = strtotime($lowHumTime);
        $convLowHumTime = date("M. d, Y H:i:s", $unixLowHumTime);
        
        $unixHighTempTime = strtotime($highTempTime);
        $convHighTempTime = date("M. d, Y H:i:s", $unixHighTempTime);
        
        $unixLowTempTime = strtotime($lowTempTime);
        $convLowTempTime = date("M. d, Y H:i:s", $unixLowTempTime);
        
        
        //Echo out highest and lowest data
        echo "Highest humidity: ". $highestHum. " on ". $convHighHumTime. "<br>";
        echo "Lowest humidity: ". $lowestHum. " on ". $convLowHumTime. "<br><br>";
        echo "Highest temperature: ". $highestTemp. " on ". $convHighTempTime. "<br>";
        echo "Lowest temperature: ". $lowestTemp. " on ". $convLowTempTime. "<br>";
        
        //Alert the user if db hasn't been updated in 5 min
        $sqlTime = "SELECT time FROM DHT ORDER BY id DESC LIMIT 1"; //select most recent time
        $result2 = $conn->query($sqlTime);
        
        //Get most recent time
        while($row2 = $result2->fetch_array()) {
            $mostRecentTime = $row2["time"];
            $unixRecentTime = strtotime($mostRecentTime); //convert to unix time
            $lastRecordTime = $unixRecentTime; //save in global variable
        }
        
        $curTime = time(); //gets current time
        $diff = $curTime - $lastRecordTime; //find the difference
        $secToMin = $diff/60; //convert to minutes
        if ($secToMin > 5) { //if it's been greater than 5 min...
            echo "<script>window.alert('Database has not been updated in 5 minutes. Last update was on ". date("M. d, Y H:i:s", $lastRecordTime). ".')</script>";
        }
        
        //Close connection
        $conn->close(); 
    ?>

    <script>
        //once the window loads...
        window.onload = function () {
            //Create a canvasJS chart
            var chart = new CanvasJS.Chart("chartContainer", {
                title: { //title of graph
                    text: "Weather Monitor Graph"
                },
                axisX: {
                    title: "Time"
                },
                axisY: { //y-axis of graph
                    title: "Humidity & Temperature"
                },
                legend: { //legends graph information
                    verticalAlign: "top",
                    horizontalAlign: "center",
                    dockInsidePlotArea: true,
                },
                data: [
                    {
                        name: "Humidity",
                        type: "line",
                        showInLegend: true,
                        //set all the data points related to humidity
                        dataPoints: <?php echo json_encode($dataHum, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        name: "Temperature",
                        type: "line",
                        showInLegend: true,
                        //set all the data points related to temperature
                        dataPoints: <?php echo json_encode($dataTemp, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart.render(); //render the graph
        }
    </script>
</body>

</html>