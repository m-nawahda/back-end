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

//$type=$obj['type'];
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} else if (isset($deliver_id) && isset($cst_id) && isset($length) && isset($item)) {
  $select_cst = "SELECT `cst_id` FROM `customer` WHERE `usr_name`='" .$cst_id. "'";
  $result1 = mysqli_query($conn, $select_cst);
  $check1 = mysqli_fetch_array($result1);
  /*$select_del = "SELECT `del_id` FROM `deliver` WHERE `usr_name`='" .$deliver_id. "'";
  $result2 = mysqli_query($conn, $select_del);
  $check2 = mysqli_fetch_array($result2);*/
  if ($check1) {
    $cst_id = $check1['cst_id'];
   // $del_id = $check2['del_id'];
   $exist = "SELECT * FROM `order` WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."'";
   $res_exist = mysqli_query($conn, $exist);
   $check = mysqli_fetch_array($res_exist);
   if($check){
     if($check['state']==0){
       if($item==$check['order']){
       return;
       }
       else {
    $update = "UPDATE `order` SET `num_poroducts`='".$length."',`cst_id`='". $cst_id."',`order`='". $item."', `deliver_id`='".$deliver_id."' WHERE `cst_id`='" .$cst_id. "' AND `deliver_id`='".$deliver_id."' AND `state`=0 ";
    $result = mysqli_query($conn, $update);
    return;
  }   
  }
   }
    
    $insert = "INSERT INTO `order`(`num_poroducts`, `cst_id`, `deliver_id`, `order`) VALUES ('" . $length . "','" . $cst_id . "','" . $deliver_id . "','" . $item . "')";
    if (mysqli_query($conn, $insert)) {
      $id=$conn->insert_id;
      echo $id;
    } else {
      echo "Error: ";
    }
  
  }
}

mysqli_close($conn);
?>