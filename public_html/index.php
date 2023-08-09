/*
____________________________________________________________
Author: SHEHAN SOORIYAARACHCHI
 Description: AUTOMATED STORAGE RETRIEVAL SYSTEM - HOME PAGE 
 ____________________________________________________________
*/
<?php 
session_start();
$connect = mysqli_connect("localhost", "u305846814_robot", "W]JFHf[8h", "u305846814_store");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"],
				'Coordinate'		=>	$_POST["hidden_Coordinate"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"],
			'Coordinate'		=>	$_POST["hidden_Coordinate"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="index.php"</script>';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Webslesson Demo | Simple PHP Mysql Shopping Cart</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<br />
			<br />
			<br />
			<h3 align="center">AUTOMATED STORAGE RETRIEVAL SYSTEM</h3><br />
			<br /><br />
			<?php
				$query = "SELECT * FROM product_table ORDER BY id ASC";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-4">
				<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<h4 class="text-info"><?php echo $row["name"]; ?></h4>

						<h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
						<input type="hidden" name="hidden_Coordinate" value="<?php echo $row["Coordinate"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

					</div>
				</form>
			</div>
			<?php
					}
				}
			?>
			<div style="clear:both"></div>
			<br />
			<h3>Order Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Item Name</th>
						<th width="10%">Quantity</th>
						<th width="20%">Price</th>
						<th width="15%">Total</th>
						<th width="5%">Action</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td>$ <?php echo $values["item_price"]; ?></td>
						<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">$ <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
					<?php
					}
					?>
						
				</table>
			</div>
			<?php
					   if(isset($_POST['checkout'])){
							$i=0;
							$test=array();
                           foreach($_SESSION["shopping_cart"] as $keys => $values){
							$Arr[ $i]['item_id'] =json_decode($values['item_id']);
							$Arr[ $i]['amount'] =json_decode($values['item_quantity']);
						    $Arr[ $i]['Coordinate'] =json_decode($values['Coordinate']);
						    array_push($test,json_decode($values['Coordinate']));
							$i++;
						   }

                            $data = json_encode($test);
                            $data2=json_encode($Arr);
							echo $data;
							echo "<br>";
							echo $data2;
							
                           $query2 = "INSERT INTO `order_table` (`OrderID`, `units`) VALUES (NULL, '$data')";
                           $result = mysqli_query($connect, $query2);
                            $query4="select MAX(OrderID) as `maxvalue` from `order_table`";
                            $res=mysqli_query($connect,$query4);
                            $data=mysqli_fetch_array($res);
                            $last=$data["maxvalue"];
                            echo "max:".$last;
                            
                           
                           $query3 = "UPDATE `order_table` SET `detail`='$data2' WHERE OrderID='$last'";
                           $result = mysqli_query($connect, $query3);
                          
                           
                           
					   }
					   ?>
					   <form method="post">
						<input type="submit" name="checkout" style="margin-top:25px;" class="btn btn-success" value="Check-out" />
						</form>
		</div>
	</div>
	<br />
	</body>
</html>

<?php
//If you have use Older PHP Version, Please Uncomment this function for removing error 

/*function array_column($array, $column_name)
{
	$output = array();
	foreach($array as $keys => $values)
	{
		$output[] = $values[$column_name];
	}
	return $output;
}*/
?>