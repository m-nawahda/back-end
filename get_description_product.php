<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$product_id=$obj['product_id'];
//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else  {
 if(isset($product_id)){
$SQL="SELECT `price`, `quantity`,`ctype_id`,`count`,`product_id` FROM `product_type` WHERE `product_id`='".$product_id."'";
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