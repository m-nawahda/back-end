<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$cst_id=$obj['usr_name'];
//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($cst_id)){

        $select_cst = "SELECT `usr_name` FROM `customer` WHERE `cst_id`='" .$cst_id. "'";
$result1 = mysqli_query($conn, $select_cst);
$check1 = mysqli_fetch_array($result1);
$usr_name=$check1['usr_name'];
$SQL="SELECT  `token` FROM `user` WHERE `usr_name`='".$usr_name."'";
$result = mysqli_query($conn, $SQL);
$check2 = mysqli_fetch_array($result);
echo $check2['token'];
}
else echo 0;

    
    mysqli_close($conn);

    

?>