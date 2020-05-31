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
$shops_num=$obj['shops_num'];
$cost=$obj['cost'];
$key=$obj['key'];
$distance=$obj['distance'];
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} 
else if (isset($deliver_id) && isset($cst_id) && isset($length) && isset($item)&&isset($price)&&isset($lat)&&isset($log)&&isset($cost)&&isset($distance)&&isset($shops_num)&&isset($key)) {
  $select_cst = "SELECT `customer`.`cst_id`,`user`.`full_name` FROM `user` JOIN `customer` ON `user`.`usr_name`=`customer`.`usr_name` WHERE `customer`.`usr_name`='" .$cst_id. "'";
  $result1 = mysqli_query($conn, $select_cst);
  $check1 = mysqli_fetch_array($result1);
  if ($check1) {
    $cst_id = $check1['cst_id'];
$full_name=$check1['full_name'];
   $exist = "SELECT `order_id`,`order`,`state`,`cost`,`price` FROM `order` WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."' and `access_deliver`= 0 and `state`=0 ";
   $res_exist = mysqli_query($conn, $exist);
   $check = mysqli_fetch_array($res_exist);
   if($check){
       if($item==$check['order']){
         echo $check['order_id'];
       return;
       }
       else {
         $old_value=$check['price']+$check['cost'];
         $new_value=$price+$cost;
         $select_amount= "SELECT `points`.`amount_points`,`points`.`point_id` from `points` join `customer` on `customer`.`point_id`=`points`.`point_id`  WHERE `customer`.`cst_id`='" .$cst_id."'";
         $result = mysqli_query($conn, $select_amount);
         $check1=mysqli_fetch_array($result);
         $amount_point=$check1['amount_points'];
         if($check1){
         if($new_value>$old_value){
           $value_dif=$new_value-$old_value;
  $amount_point=$check1['amount_points']-$value_dif; 
          }
          else{
            $value_dif=$old_value-$new_value;
            $amount_point=$check1['amount_points']-$value_dif;  
          } 
          $time = time();
$date = date('Y-m-d H:i:s');
$update="UPDATE `points` SET `amount_points`='".$amount_point."',`date_mod`='".$date."' WHERE `point_id`='".$check1['point_id']."'";
$result = mysqli_query($conn, $update);

    $update = "UPDATE `order` SET `address_lat`='".$lat."',`address_log`='".$log."',`full_name`='".$full_name."',`num_products`='".$length."',`price`='".$price."',`cst_id`='". $cst_id."',`order`='". $item."', `deliver_id`='".$deliver_id." ,`key`='".$key."', `distance`='".$distance."', `shops_num`='".$shops_num."', `cost`='".$cost."' WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."' AND `state`=0 ";
    $result = mysqli_query($conn, $update);
    
    $select_id="SELECT `order_id` FROM `order` WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."'and`address_lat`='".$lat."' and `address_log`='".$log."'and `num_products`='".$length."' and `price`='".$price."' and `order`='". $item."' and `full_name`='".$full_name."'";
  $result_id=mysqli_query($conn, $select_id);
  $check=mysqli_fetch_array($result_id);
  if($check){
  echo $check['order_id'];
  return;
  }
  }
  else {
    echo $check['order_id'];
return;
  }
}   

  }
  
    else {
    $insert = "INSERT INTO `order`(`num_products`, `cst_id`, `deliver_id`, `order`,`price`,`full_name`,`address_lat`,`address_log`,`key`,`cost`,`shops_num`,`distance`) VALUES ('".$length."','".$cst_id."','". $deliver_id ."','". $item."','". $price."','". $full_name."','". $lat."','". $log."','". $key."','". $cost."','". $shops_num."','". $distance."')";
    if (mysqli_query($conn, $insert)) {
      $id=$conn->insert_id;
      $select_amount= "SELECT `points`.`amount_points`,`points`.`point_id` from `points` join `customer` on `customer`.`point_id`=`points`.`point_id`  WHERE `customer`.`cst_id`='" .$cst_id."'";
      $result = mysqli_query($conn, $select_amount);
      $check1=mysqli_fetch_array($result);
      $new_amount=$check1['amount_points']-($cost+$price);
      $time = time();
$date = date('Y-m-d H:i:s');
$update="UPDATE `points` SET `amount_points`='".$new_amount."',`date_mod`='".$date."' WHERE `point_id`='".$check1['point_id']."'";
$result = mysqli_query($conn, $update);
      echo $id;
    }
    } 
  
}
}
    else {
      echo "Error:";
    }
  
  


mysqli_close($conn);
?>