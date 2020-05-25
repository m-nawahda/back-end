<?php
//if(isset($_POST['name'])&&isset($_POST['address'])&&isset($_POST['password'])&&isset($_POST['type'])&&isset($_POST['usr_name'])&&isset($_POST['photo'])){
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$user_name=$obj['user_name'];
$lat=$obj['lat'];
$log=$obj['log'];
$name=$obj['name'];
// Check connection
    if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($user_name)&&isset($lat)&&isset($log)&&isset($name)&&$name!=""){
        $select_cst = "SELECT `cst_id` FROM `customer` WHERE `usr_name`='" .$user_name. "'";
        $result1 = mysqli_query($conn, $select_cst);
        $check1 = mysqli_fetch_array($result1);
        if(isset($check1['cst_id'])){
            $cst_id=$check1['cst_id'];
        $select="SELECT `location_id`,`lat`,`log` FROM `favorite_locations` WHERE `name_address`='" .$name."' and `cst_id`='" .$cst_id."' ";
        $result = mysqli_query($conn, $select);
        $check = mysqli_fetch_array($result);
if(isset($check)){
if($check['lat']!=$lat||$check['log']!=$log)
 $sql=" UPDATE `favorite_locations` SET `lat`='".$lat."',`log`='".$log."' WHERE `log`='".$check['location_id']."' ";
}
else if(!isset($check)){
    $sql="INSERT INTO `favorite_locations`(`lat`, `log`, `cst_id`, `name_address`) VALUES ('".$lat."','".$log."','".$cst_id."','".$name."')";

}
    $result2 = mysqli_query($conn, $sql);

    // Converting the message into JSON format.
   $inserted ="Successfully added";
    
   // Echo the message on Screen.
    echo $inserted ; 

}
        
}
mysqli_close($conn);



?>