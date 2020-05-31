<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$eprice=$obj['eprice'];
$sprice=$obj['sprice'];
$erate=$obj['erate'];
$srate=$obj['srate'];

if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else  {
if(isset($eprice)&&isset($erate)&&isset($sprice)&&isset($srate)){
$SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`car_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
`user`.`log`,`user`.`full_name`,`photos`.`photo`,`user`.`token` FROM `deliver` JOIN `user` JOIN `photos` ON `deliver`.`usr_name`=`user`.`usr_name` and `user`.`photo_id`=`photos`.`photo_id` WHERE `rate` BETWEEN '".$srate."' AND '".$erate."' AND `price` BETWEEN '".$sprice."' AND '".$eprice."' and `deliver`.`state`=1 ";
}
else if(isset($eprice)&&isset($sprice)){
    $SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`car_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
    `user`.`log`,`user`.`full_name`,`photos`.`photo`,`user`.`token` FROM `deliver` JOIN `user` JOIN `photos` ON `deliver`.`usr_name`=`user`.`usr_name` and `user`.`photo_id`=`photos`.`photo_id` WHERE `price` BETWEEN '".$sprice."' AND '".$eprice."' and `deliver`.`state`=1";
  }
else if(isset($srate)&&isset($erate)){
  $SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`car_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
  `user`.`log`,`user`.`full_name`,`photos`.`photo`,`user`.`token` FROM `deliver` JOIN `user` JOIN `photos` ON `deliver`.`usr_name`=`user`.`usr_name` and `user`.`photo_id`=`photos`.`photo_id` WHERE `rate` BETWEEN '".$srate."' AND '".$erate."' and `deliver`.`state`=1";
}
else {
    $SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`car_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
  `user`.`log`,`user`.`full_name`,`photos`.`photo`,`user`.`token` FROM `deliver` JOIN `user` JOIN `photos` ON `deliver`.`usr_name`=`user`.`usr_name` and `user`.`photo_id`=`photos`.`photo_id` where `deliver`.`state`=1";

}

$result = mysqli_query($conn, $SQL); 
if ($result->num_rows >0) {
 while($row[] = $result->fetch_assoc()) {
 
 $item = $row;
 
 $json = json_encode($item);
 
 }
 echo $json; 
}
else {
    $Message = "no available delivery ";
    $MessageJSON = json_encode($Message);
            
    // Echo the message on Screen.
     echo $MessageJSON ;    
    }
    }
    mysqli_close($conn);

    

?>