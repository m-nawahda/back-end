<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$usr_name=$obj['deliver_id'];
$state=$obj['state'];
//$type=$obj['type'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($usr_name)){
$SQL="SELECT `state` FROM `deliver` WHERE `usr_name`='".$usr_name."'";
$result = mysqli_query($conn, $SQL);
$check = mysqli_fetch_array($result);
if (!isset($check)) {
    $emailnotExist = 0;
    // Converting the message into JSON format.
    $notexistEmailJSON = json_encode($emailnotExist);
    // Echo the message on Screen.
    echo $notexistEmailJSON;
}
else{
$update = "UPDATE `deliver` SET `state`='". $state ."'  WHERE `usr_name`='" . $usr_name . "'";
$result = mysqli_query($conn, $update);

$updated = 1;

// Converting the message into JSON format.
$updatedJSON = json_encode($updated);

// Echo the message on Screen.
echo $updatedJSON;
}


    }
    mysqli_close($conn);

    

?>