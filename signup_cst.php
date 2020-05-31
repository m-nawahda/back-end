<?php
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$name=$obj['name'];
$address=$obj['address'];
$password=sha1($obj['password']);
$type='customer';
$street_name=$obj['street_name'];
$usr_name=$obj['usr_name'];
$token=$obj['token'];
$lat=$obj['lat'];
$log=$obj['log'];

// Check connection
    if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else 
    {
        if(isset($token)&&isset($usr_name)&&isset($street_name)&&isset($type)&&isset($password)&&isset($address)&&isset($name)&&isset($lat)&&isset($log)){
$select="SELECT `usr_name` FROM `user` WHERE `usr_name`='".$usr_name."'";
$check = mysqli_fetch_array(mysqli_query($conn,$select));

if(!isset($check)){ 
    $sql_address="INSERT INTO `address`( `street_name`, `subaddress`) VALUES ('".$street_name."','".$address."')";
    $result_address=mysqli_query($conn,$sql_address);
    $address_id=$conn->insert_id;
        $SQL = "INSERT INTO `user`( `full_name`, `address_id`, `password`, `type`, `usr_name`,`token`,`lat`,`log`,`photo_id`) 
        VALUES ('".$name."','".$address_id."','".$password."','".$type."','".$usr_name."','".$token."','".$lat."','".$log."',8)";
        
        $result = mysqli_query($conn, $SQL);
        $time = time();
        $date = date('Y-m-d H:i:s');
        $sql_point="INSERT INTO `points`(`amount_points`, `date_mod`) VALUES (0,'".$date."')";
        $result = mysqli_query($conn, $sql_point);
        $point_id=$conn->insert_id;
        $sql_cst="INSERT INTO `customer`(`usr_name`,`rate`,`point_id`) VALUES ('".$usr_name."',0,'".$point_id."')";
        $result_cst=mysqli_query($conn,$sql_cst);
      //  echo $conn->error;
        if (isset($conn->insert_id))
        {
echo "successfully";            
        }
        
        else 
        {
        
            echo "fail" ; 
        }
}
else{
        echo 'already exist'; 
}
}
else {
    echo "please enter all information" ; 
}
    }
mysqli_close($conn);



?>