<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$deliver_id = $obj['deliver_id'];
$cst_id = $obj['cst_id'];
$order_id=$obj['order_id'];

//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($deliver_id)&&isset($cst_id)&&isset($order_id)){
$SQL="SELECT * FROM `order` WHERE `order_id`='".$order_id."' and `deliver_id`='".$deliver_id."' and `cst_id`='".$cst_id."' ";
$result = mysqli_query($conn, $SQL);
$check=mysqli_fetch_array($result);
if($check){
echo $check['order'];
}
else {
    echo "no items";
}
}

    
    mysqli_close($conn);

    

?>