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
$Type_car=$obj['Type_car'];
$permit_id=sha1($obj['permit_id']);
$type='deliver';
$price=$obj['price'];
$usr_name=$obj['usr_name'];
$street_name=$obj['street_name'];
$token=$obj['token'];
$lat=$obj['lat'];
$log=$obj['log'];
$car_id=$obj['car_id'];
// Check connection
    if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else 
    {
        if(isset($car_id)&&isset($token)&&isset($usr_name)&&isset($street_name)&&isset($type)&&isset($password)&&isset($address)&&isset($name)&&isset($lat)&&isset($log)&&isset($price)&&isset($Type_car)){
$select="SELECT `usr_name` FROM `user` WHERE `usr_name`='".$usr_name."'";
$check = mysqli_fetch_array(mysqli_query($conn,$select));

if(!isset($check)){ 
    $sql_address="INSERT INTO `address`( `street_name`, `subaddress`) VALUES ('".$street_name."','".$address."')";
    $result_address=mysqli_query($conn,$sql_address);
    $address_id=$conn->insert_id;
        $SQL = "INSERT INTO `user`(`full_name`, `address_id`, `password`, `type`, `usr_name`,`token`,`lat`,`log`,`photo_id`) 
        VALUES ('".$name."','".$address_id."','".$password."','".$type."','".$usr_name."','".$token."','".$lat."','".$log."',9)";
        $result = mysqli_query($conn, $SQL);



        $time = time();
        $date = date('Y-m-d H:i:s');
        $sql_point="INSERT INTO `point_deliver`(`amount_points`, `date_mod`) VALUES (0,'".$date."')";
        $result = mysqli_query($conn, $sql_point);
        $point_id=$conn->insert_id;


        $sql_del="INSERT INTO `deliver`(`usr_name`,`car_id`,`permit_id`,`price`,`Type_car`,`point_id`) 
        VALUES ('".$usr_name."','".$car_id."','".$permit_id."','".$price."','".$Type_car."','".$point_id."')";
        $result_cst=mysqli_query($conn,$sql_del);
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