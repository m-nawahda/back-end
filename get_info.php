<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$usr_name=$obj['usr_name'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($usr_name)){
    
        $select = "SELECT `photos`.`photo` ,`user`.`full_name` FROM `photos`join `user` on `photos`.`photo_id`=`user`.`photo_id`  WHERE `user`.`usr_name`='" .$usr_name. "' ";
$result = mysqli_query($conn, $select);
$row[] = $result->fetch_assoc();
echo json_encode($row);
}
else echo 0;

    
    mysqli_close($conn);

    

?>