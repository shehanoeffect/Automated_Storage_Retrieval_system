/*
____________________________________________________________
Author: SHEHAN SOORIYAARACHCHI
 Description:API TO READ THE LAST ORDER
 ____________________________________________________________
*/

<?php
$connect = mysqli_connect("localhost", "u305846814_robot", "W]JFHf[8h", "u305846814_store");
if(!$connect){echo "connect failed";}
else{
$query="select MAX(OrderID) as `maxvalue` from `order_table`";//as `maxvalue` 
$res=mysqli_query($connect,$query);
$data=mysqli_fetch_array($res);
$max=$data["maxvalue"];
echo "{";
echo "\"LastID\":".$max.",";


$query2="select * FROM `order_table` WHERE `OrderID`='$max'";//as `maxvalue` 
$res2=mysqli_query($connect,$query2);
$data2=mysqli_fetch_array($res2);
echo "\"units\":".$data2['units'];
}
echo "}";
?>
