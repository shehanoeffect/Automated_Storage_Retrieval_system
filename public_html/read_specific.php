
/*
____________________________________________________________
Author: SHEHAN SOORIYAARACHCHI
 Description: API TO SELECT A SPECIFIC ORDER
 ____________________________________________________________
*/


<?php
$servername = "localhost";
$username = "u305846814_robot";
$password = "W]JFHf[8h";
$dbname = "u305846814_";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$items=array();
$sql = "SELECT units FROM order_table WHERE OrderID=1";
$result = $conn->prepare($sql);
$result->execute();
$result->bind_result($units);
while($result->fetch()){
    $temp=[
      
       $units
    ];

    array_push($items,$temp);
}

echo (json_encode($items));


$conn->close();
    
?>