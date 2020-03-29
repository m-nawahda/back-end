<?php
//if(isset($_POST['name'])&&isset($_POST['address'])&&isset($_POST['password'])&&isset($_POST['type'])&&isset($_POST['usr_name'])&&isset($_POST['photo'])){
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$key=$obj['key'];
$usr_name=$obj['usr_name'];
//$city=$obj['city'];
//$sub_address=$obj['sub_address'];

// Check connection
    if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else  if(isset($key)&&isset($usr_name))
    {   
       
        $select="SELECT * FROM `keys` WHERE  `usr_name`='".$usr_name."' AND  `key`='".$key."'";
        $result = mysqli_query($conn, $select);
        $check = mysqli_fetch_array($result);

if(!isset($check)){
$message="this key is not available";

            // Converting the message into JSON format.
            $notexistKeyJSON = json_encode($message);
            
            // Echo the message on Screen.
             echo $notexistKeyJSON ; 
}
else{
//$row=mysqli_fetch_assoc($result);
if($check['state']==1){
    $message="this key is not available";
    // Converting the message into JSON format.
    $notexistKeyJSON = json_encode($message);
    // Echo the message on Screen.
     echo $notexistKeyJSON ; 
}
else {
$amount=$check['amount'];
$update="UPDATE `keys` SET `state`= 1 WHERE `key`='".$key."' ";
$stmt = $conn->prepare($update);
// execute the query
$stmt->execute();
echo json_decode($amount);
}
}

}
else {

   $message="Please Enter the key";
    // Converting the message into JSON format.
    $notexistKeyJSON = json_encode($message);
    // Echo the message on Screen.
     echo $notexistKeyJSON ; 
}

   mysqli_close($conn);



?>