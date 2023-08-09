/*
____________________________________________________________
Author: SHEHAN SOORIYAARACHCHI
 Description: API TO GET THE HIGHEST ORDER ID
 ____________________________________________________________
*/

<?php
$connect = mysqli_connect("localhost", "u305846814_robot", "W]JFHf[8h", "u305846814_store");
if(!$connect){echo "connect failed";}
else{
$query="select MAX(OrderID) as `maxvalue` from `order_table`";//as `maxvalue` 
$res=mysqli_query($connect,$query);
$data=mysqli_fetch_array($res);
echo "max:".$data["maxvalue"];}
?>

