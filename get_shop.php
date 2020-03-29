<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else  {
if(isset($type)){
//    $SQL="SELECT * FROM `deliver` WHERE  `rate` BETWEEN '".$srate."' AND '".$erate."' AND `price` BETWEEN '".$sprice."' AND '".$eprice."'";
$SQL="SELECT `user`.`usr_name`, `user`.`full_name`,`user`.`lat`, `user`.`log` FROM `user` JOIN `photos` JOIN `seller` ON `user`.`photo_id`=`photos`.`photo_id` AND `seller`.`usr_name`=`user`.`usr_name` WHERE `user`.`type`='seller'  AND `seller`.`type`='".$type."'";
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
    $Message = "no available shops";
    $MessageJSON = json_encode($Message);
            
    // Echo the message on Screen.
     echo $MessageJSON ;    
    }
    }
    mysqli_close($conn);

    

?>