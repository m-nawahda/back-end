<?php
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$key = $obj['key'];
$order_id=$obj['order_id'];
$deliver_id=$obj['deliver_id'];
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} 
else if (isset($order_id)&&isset($deliver_id)&&isset($key)) {
    $select_deliver = "SELECT `deliver`.`del_id`,`deliver`.`point_id`,`point_deliver`.`amount_points` from `deliver` join `point_deliver` on `point_deliver`.`point_id`=`deliver`.`point_id` WHERE `deliver`.`usr_name`='" .$deliver_id."'";
    $result_del = mysqli_query($conn, $select_deliver);
    $check1=mysqli_fetch_array($result_del);
    if($check1){
$deliver_id=$check1['del_id'];
  $select_order = "SELECT `key`,`cost`,`price` from `order` WHERE `order_id`='" .$order_id."' and `access_deliver`=0 and `deliver_id`='" .$deliver_id."' ";
  $result1 = mysqli_query($conn, $select_order);
  $check=mysqli_fetch_array($result1);
    $total_amount=$check['cost']+$check['price'];

if($check['key']==$key){
        $new_amount=$check1['amount_points']+$total_amount;
    $point_id=$check1['point_id'];
$time = time();
$date = date('Y-m-d H:i:s');


$update_amount= "UPDATE `point_deliver` SET `amount_points`='".$new_amount."',`date_mod`='".$date."' WHERE `point_id`='".$point_id."'";
         $result = mysqli_query($conn, $update_amount);
$update_acc="UPDATE `order` SET `access_deliver`=1 WHERE `order_id`='" .$order_id."'";
$result = mysqli_query($conn, $update_acc);

echo 'successful';
}
else {
    echo 'fail';

}
}  
}
else {
    echo 'please enter key';
}

mysqli_close($conn);
?>