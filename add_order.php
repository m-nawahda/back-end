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
$lat=$obj['lat'];
$log=$obj['log'];

if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} 
else if (isset($deliver_id) && isset($cst_id) && isset($length) && isset($item)&&isset($price)&&isset($lat)&&isset($log)) {
  $select_cst = "SELECT `customer`.`cst_id`,`user`.`full_name` FROM `user` JOIN `customer` ON `user`.`usr_name`=`customer`.`usr_name` WHERE `customer`.`usr_name`='" .$cst_id. "'";
  $result1 = mysqli_query($conn, $select_cst);
  $check1 = mysqli_fetch_array($result1);
  if ($check1) {
    $cst_id = $check1['cst_id'];
$full_name=$check1['full_name'];
   $exist = "SELECT * FROM `order` WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."'";
   $res_exist = mysqli_query($conn, $exist);
   $check = mysqli_fetch_array($res_exist);
   if($check){
     if($check['state']==0){
       if($item===$check['order']){
       return;
       }
       else {
    $update = "UPDATE `order` SET `address_lat`='".$lat."',`address_log`='".$log."',`full_name`='".$full_name."',`num_products`='".$length."',`price`='".$price."',`cst_id`='". $cst_id."',`order`='". $item."', `deliver_id`='".$deliver_id."' WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."' AND `state`=0 ";
    $result = $conn->query($update);
    $select_id="SELECT `order_id` FROM `order` WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."'and`address_lat`='".$lat."' and `address_log`='".$log."'and `num_products`='".$length."' and `price`='".$price."' and `order`='". $item."' and `full_name`='".$full_name."'";
  $result_id=$conn->query($select_id);
  $check=mysqli_fetch_array($result_id);
  if($check){
  echo $check['order_id'];
  return;
  }
  }   
  }
   }
    
    $insert = "INSERT INTO `order`(`num_products`, `cst_id`, `deliver_id`, `order`,`price`,`full_name`,`address_lat`,`address_log`) VALUES ('".$length."','".$cst_id."','". $deliver_id ."','". $item."','". $price."','". $full_name."','". $lat."','". $log."')";
    if (mysqli_query($conn, $insert)) {
      $id=$conn->insert_id;
      echo $id;
    } 
    else {
      echo "Error: ";
    }
  
  }
}

mysqli_close($conn);
?>