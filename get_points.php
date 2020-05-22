<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$usr_name=$obj['usr_name'];
//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($usr_name)){

        $select_cst = "SELECT `point_id` FROM `customer` WHERE `usr_name`='" .$usr_name. "'";
$result1 = mysqli_query($conn, $select_cst);
$check1 = mysqli_fetch_array($result1);
$point_id=$check1['point_id'];
$SQL="SELECT  `amount_points` FROM `points` WHERE `point_id`='".$point_id."'";
$result = mysqli_query($conn, $SQL);
$check2 = mysqli_fetch_array($result);
echo $check2['amount_points'];
}
else echo 0;

    
    mysqli_close($conn);

    

?>