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
        $select = "SELECT `user`.`lat`,`user`.`log` FROM `user`join `deliver` on `deliver`.`usr_name`=`user`.`usr_name`  WHERE `deliver`.`del_id`='" .$usr_name. "' ";
$result = mysqli_query($conn, $select);
$row[] = $result->fetch_assoc();
echo json_encode($row);
}
else echo 0;

    
    mysqli_close($conn);

    

?>