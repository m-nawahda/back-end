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
//    $SQL="SELECT * FROM `deliver` WHERE  `rate` BETWEEN '".$srate."' AND '".$erate."' AND `price` BETWEEN '".$sprice."' AND '".$eprice."'";
$SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`card_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
`user`.`log`,`user`.`full_name` FROM `deliver` JOIN `user` ON `deliver`.`usr_name`=`user`.`usr_name` WHERE `rate` BETWEEN '".$srate."' AND '".$erate."' AND `price` BETWEEN '".$sprice."' AND '".$eprice."'";
}
else if(isset($eprice)&&isset($sprice)){
    //$SQL="SELECT * FROM `deliver` WHERE  `price` BETWEEN '".$sprice."' AND '".$eprice."' ";
    $SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`card_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
    `user`.`log`,`user`.`full_name` FROM `deliver` JOIN `user` ON `deliver`.`usr_name`=`user`.`usr_name` WHERE `price` BETWEEN '".$sprice."' AND '".$eprice."'";
  }
else if(isset($srate)&&isset($erate)){
  //  $SQL="SELECT * FROM `deliver` WHERE  `rate` BETWEEN '".$srate."' AND '".$erate."'";
  $SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`card_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
  `user`.`log`,`user`.`full_name` FROM `deliver` JOIN `user` ON `deliver`.`usr_name`=`user`.`usr_name` WHERE `rate` BETWEEN '".$srate."' AND '".$erate."'";
}
else {
    $SQL="SELECT `deliver`.`del_id`, `deliver`.`usr_name`, `deliver`.`card_id`, `deliver`.`permit_id`, `deliver`.`price`, `deliver`.`Type_car`, `deliver`.`rate`,`user`.`lat`,
  `user`.`log`,`user`.`full_name` FROM `deliver` JOIN `user` ON `deliver`.`usr_name`=`user`.`usr_name`";

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