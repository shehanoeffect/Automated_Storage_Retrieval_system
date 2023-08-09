/*
____________________________________________________________
Author: SHEHAN SOORIYAARACHCHI
 Description:READ ALL THE ITEMS IN CART
 ____________________________________________________________
*/

<?php
$servername = "localhost";
$username = "u305846814_robot";
$password = "W]JFHf[8h";
$dbname = "u305846814_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$items=array();
$sql = "SELECT units FROM order_table";
$result = $conn->prepare($sql);
$result->execute();
$result->bind_result($units);
while($result->fetch()){
    $temp=[
      $units
    ];

    array_push($items,$temp);
}

echo json_encode($items);



//echo "<br>"."the selected data is :".$ar[2]["status"];
  

$conn->close();
    
?>