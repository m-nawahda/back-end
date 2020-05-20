<?php
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$order_id = $obj['order_id'];
//$type=$obj['type'];
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} else if (isset($order_id)) {
  $select_cst = "UPDATE `order` SET `deliver_id`=-1 WHERE `order_id`='" .$order_id."'and `state` = 0";
  $result1 = mysqli_query($conn, $select_cst);
  }

mysqli_close($conn);
?>