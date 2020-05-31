<?php
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$order_id = $obj['order_id'];
$deliver_id=$obj['deliver_id'];
$cost=$obj['cost'];
$cst_id=$obj['cst_id'];
//$type=$obj['type'];
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} else if (isset($order_id)&&isset($deliver_id)) {


  $select_cst = "SELECT `customer`.`cst_id` FROM `user` JOIN `customer` ON `user`.`usr_name`=`customer`.`usr_name` WHERE `customer`.`usr_name`='" .$cst_id. "'";
  $result1 = mysqli_query($conn, $select_cst);
  $check0 = mysqli_fetch_array($result1);
$cst_id=$check0['cst_id'];





$select_order = "SELECT `cost` from `order` WHERE `order_id`='" .$order_id."'";
  $result1 = mysqli_query($conn, $select_order);
  $check=mysqli_fetch_array($result1);
$old_cost=$check['cost'];
 







$select_amount= "SELECT `points`.`amount_points`,`points`.`point_id` from `points` join `customer` on `customer`.`point_id`=`points`.`point_id`  WHERE `customer`.`cst_id`='" .$cst_id."'";
  $result = mysqli_query($conn, $select_amount);
  $check1=mysqli_fetch_array($result);
  $new_amount=$check1['amount_points']+$old_cost-$cost;
  $time = time();
  $date = date('Y-m-d H:i:s');
 
 
 
 
 
  $update="UPDATE `points` SET `amount_points`='".$new_amount."',`date_mod`='".$date."' WHERE `point_id`='".$check1['point_id']."'";
  $result = mysqli_query($conn, $update);




  $select_cst = "UPDATE `order` SET `deliver_id`='".$deliver_id."',`cost`='".$cost."' WHERE `order_id`='".$order_id."'";
  $result1 = mysqli_query($conn, $select_cst);





  }

mysqli_close($conn);
?>