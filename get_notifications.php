<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$deliver_id=$obj['deliver_id'];
//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($deliver_id)){
    $select_del = "SELECT `del_id` FROM `deliver` WHERE `usr_name`='" .$deliver_id. "'";
    $result2 = mysqli_query($conn, $select_del);
    $check2 = mysqli_fetch_array($result2);
    $del_id = $check2['del_id'];
    if(isset($del_id)){
$SQL="SELECT `order_id`, `num_products`, `cst_id`,`address_lat`,`address_log`,`price`,`full_name` FROM `order` WHERE `deliver_id`='".$del_id."' and `state`= 0";
//`photos`.`photo`
$result = mysqli_query($conn, $SQL);
    
if ($result->num_rows >0) {
 while($row[] = $result->fetch_assoc()) {
 $item = $row;
 $json = json_encode($item);
 }
 echo $json; 
}
else {
    $Message = "no available order";
    $MessageJSON = json_encode($Message);
            
    // Echo the message on Screen.
     echo $MessageJSON ;    
    }
    }
}
    
    mysqli_close($conn);

    

?>