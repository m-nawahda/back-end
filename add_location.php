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
$name="aasdasd";
// Check connection
    if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($user_name)){
        $select_cst = "SELECT `cst_id` FROM `customer` WHERE `usr_name`='" .$user_name. "'";
        $result1 = mysqli_query($conn, $select_cst);
        $check1 = mysqli_fetch_array($result1);
        if(isset($check1['cst_id'])){
            $cst_id=$check1['cst_id'];
        $select="SELECT `lat`,`log` FROM `favorite_locations` WHERE `lat`='" .$lat."' and `log`='" .$log. "'and `cst_id`='" .$cst_id."' ";
        $result = mysqli_query($conn, $select);
        $check = mysqli_fetch_array($result);
if(!isset($check)){
 $sql="INSERT INTO `favorite_locations`(`lat`, `log`, `cst_id`, `name_address`) VALUES ('".$lat."','".$log."','".$cst_id."','".$name."')";
    $result2 = mysqli_query($conn, $sql);

    // Converting the message into JSON format.
   $inserted ="Successfully added";
    
   // Echo the message on Screen.
    echo $inserted ; 

}
else {
    $exist ="already exist";
    
   // Echo the message on Screen.
    echo $exist ;
}
        }
}
mysqli_close($conn);



?>