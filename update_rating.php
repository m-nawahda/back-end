<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$cst_id=$obj['cst_id'];
$rate=$obj['rate'];
$deliver_id=$obj['deliver_id'];

if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($rate)&&isset($cst_id)&&isset($deliver_id)){
        $select_cst = "SELECT `cst_id` FROM `customer` WHERE `usr_name`='" .$cst_id. "'";
  $result1 = mysqli_query($conn, $select_cst);
  $check1 = mysqli_fetch_array($result1);
  $cst_id=$check1['cst_id'];
$SQL="SELECT * FROM `rating` WHERE `deliver_id`='".$deliver_id."'and`cst_id`='".$cst_id."'";
$result = mysqli_query($conn, $SQL);
$check = mysqli_fetch_array($result);
if (isset($check)) {
    $update="UPDATE `rating` SET `rate`='".$rate."' WHERE `deliver_id`='".$deliver_id."'and`cst_id`='".$cst_id."' ";
    $result = mysqli_query($conn, $update);
    $SQL="SELECT `rate` FROM `rating` WHERE `deliver_id`='".$deliver_id."'";
    $result = mysqli_query($conn, $SQL);
    $num=$result->num_rows;
    $rating=0;
if($num>0){
    while($row = $result->fetch_assoc()) {
 
        $value = $row['rate'];
  $rating=$rating+$value;     
           
}
$new_rate=$rating/$num;
       $update_rate="UPDATE `deliver` SET `rate`='".$new_rate."' WHERE `del_id`='".$deliver_id."'"; 
       $result = mysqli_query($conn, $update_rate);
echo $new_rate;
    }
}
else{
$insert="INSERT INTO `rating`(`cst_id`, `rate`, `deliver_id`) VALUES ('".$cst_id."','".$rate."','".$deliver_id."')";
$result = mysqli_query($conn, $insert);

$SQL="SELECT  `rate` FROM `rating` WHERE `deliver_id`='".$deliver_id."'";
$result = mysqli_query($conn, $SQL);
$num=$result->num_rows;
$rating=0;
if($num>0){
while($row = $result->fetch_assoc()) {

    $value = $row['rate'];
$rating=$rating+$value;     
       
}
$new_rate=$rating/$num;
   $update_rate="UPDATE `deliver` SET `rate`='".$new_rate."' WHERE `del_id`='".$deliver_id."'"; 
   $result = mysqli_query($conn, $update_rate);
echo $new_rate;
}

}


    }
    mysqli_close($conn);

    

?>