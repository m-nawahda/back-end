<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$cst_id=$obj['cst_id'];

if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($cst_id)){
        $select = "SELECT  `description`,`date`,`deliver_name`,`photo`  FROM `comment_cst` WHERE `usr_id`='".$cst_id."' ";
$result = mysqli_query($conn, $select);
if ($result->num_rows > 0) {
    while($row[] = $result->fetch_assoc()) {
    $item = $row;
    $json = json_encode($item);
    
    }
    echo $json; 
   }
   else echo "no comments";

}   
else echo "no comments";  
    mysqli_close($conn);

    

?>