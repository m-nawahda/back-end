<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$seller_id=$obj['seller_id'];
//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else  {
 if(isset($seller_id)){
$SQL="SELECT`product_id`, `description`, `name`,`type` FROM `product` WHERE `seller_id`='".$seller_id."'";
//`photos`.`photo`
$result = mysqli_query($conn, $SQL);
}
if ($result->num_rows >0) {
 while($row[] = $result->fetch_assoc()) {
 
 $item = $row;
 
 $json = json_encode($item);
 }
 echo $json; 

}
else {
    $Message = "no available product";
    $MessageJSON = json_encode($Message);
            
    // Echo the message on Screen.
     echo $MessageJSON ;    
    }
    }
    mysqli_close($conn);

    

?>