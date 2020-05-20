<?php
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$deliver_id = $obj['deliver_id'];
$cst_id = $obj['cst_id'];
$length = $obj['length'];
$item = $obj['obj'];
$price=$obj['price'];
//$type=$obj['type'];
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} else if (isset($deliver_id) && isset($cst_id) && isset($length) && isset($item)&&isset($price)) {
  $select_cst = "SELECT `cst_id` FROM `customer` WHERE `usr_name`='" .$cst_id. "'";
  $result1 = mysqli_query($conn, $select_cst);
  $check1 = mysqli_fetch_array($result1);
  /*$select_del = "SELECT `del_id` FROM `deliver` WHERE `usr_name`='" .$deliver_id. "'";
  $result2 = mysqli_query($conn, $select_del);
  $check2 = mysqli_fetch_array($result2);*/
  if ($check1) {
    $cst_id = $check1['cst_id'];
   // $del_id = $check2['del_id'];
   $update = "UPDATE `order` SET `num_products`='".$length."',`price`='".$price."',`cst_id`='". $cst_id."',`order`='". $item."', `deiver_id`='".$deliver_id."' WHERE `order_id` = '".$order_id."'";
   if (mysqli_query($conn, $insert)) {
      echo "New record created successfully";
    } else {
      echo "Error: ";
    }
  }
}

mysqli_close($conn);
