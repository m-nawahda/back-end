<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$user_name=$obj['user_name'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($user_name)){
$SQL="SELECT `favorite_locations`.`lat`, `favorite_locations`.`log`,`favorite_locations`.`name_address` FROM `favorite_locations` JOIN `customer` ON `favorite_locations`.`cst_id`=`customer`.`cst_id` WHERE `customer`.`usr_name`='".$user_name."'";
$result = mysqli_query($conn, $SQL);
if ($result->num_rows >0) {
 while($row[] = $result->fetch_assoc()) {
 $item = $row;
 $json = json_encode($item);
 }
 echo $json; 

}
else {
    $Message = "no available address";            
    // Echo the message on Screen.
     echo $Message ;    
    }
}
    mysqli_close($conn);

    

?>