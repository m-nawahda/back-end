<?php
//if(isset($_POST['name'])&&isset($_POST['address'])&&isset($_POST['password'])&&isset($_POST['type'])&&isset($_POST['usr_name'])&&isset($_POST['photo'])){
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$name=$obj['name'];
$address=$obj['address'];
$password=$obj['password'];
$type='customer';
$usr_name=$obj['usr_name'];
$price=$obj['price'];
$card_id=md5($obj['card_id']);
$type_car=$obj['type_car'];
//$city=$obj['city'];
//$sub_address=$obj['sub_address'];

// Check connection
    if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else 
    {
$select="SELECT `usr_name` FROM `user` WHERE `usr_name`='".$usr_name."'";
$check = mysqli_fetch_array(mysqli_query($conn,$select));

if(!isset($check)){
 
    $city_sql1="SELECT `city_id` FROM `city` WHERE `city_name`='".$address."'";
     $city_id=mysqli_query($conn, $city_sql1);
        $row = mysqli_fetch_assoc($city_id);

    
    $sql_address="INSERT INTO `address`( `city_id`, `subaddress`) VALUES ('".$row['city_id']."','nablus')";
    $result_address=mysqli_query($conn,$sql_address);
    $sql_last1="SELECT `address_id` FROM `address` WHERE 1";
    $sql_last2=mysqli_query($conn,$sql_last1);
while($last=mysqli_fetch_assoc($sql_last2)){
    $last1=$last['address_id'];

    }
        $SQL = "INSERT INTO `user`( `full_name`, `address_id`, `password`, `type`, `usr_name`) 
        VALUES ('".$name."','".$last1."','".$password."','".$type."','".$usr_name."')";
        
        $result = mysqli_query($conn, $SQL);

        //must be review when know attribute should be added 
        $sql_cst="INSERT INTO `deliver`( `usr_name`) VALUES ('".$usr_name."')";
        $result_cst=mysqli_query($conn,$sql_cst);
      //  echo $conn->error;
        if (!$result_cst)
        {
            $emailExist = "failed added";
	 
            // Converting the message into JSON format.
           $existEmailJSON = json_encode($emailExist);
            
           // Echo the message on Screen.
            echo $existEmailJSON ; 
            $conn->close();
            
        }
        
        else 
        {
            $emailExist = "succesfully";
	 
            // Converting the message into JSON format.
           $existEmailJSON = json_encode($emailExist);
            
           // Echo the message on Screen.
            echo $existEmailJSON ; 
        }
}
else{
    $emailnotExist = 'already exist';
	 
    // Converting the message into JSON format.
   $existEmailJSON = json_encode($emailnotExist);
    
   // Echo the message on Screen.
    echo $existEmailJSON ; 
}
}
mysqli_close($conn);



?>