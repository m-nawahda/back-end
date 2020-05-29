<?php 
$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$cst_id=$obj['cst_id'];
$comment=$obj['comment'];
$deliver_id=$obj['deliver_id'];

if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else if(isset($cst_id)&&isset($comment)&&isset($deliver_id)){
        $select_cst = "SELECT`deliver`.`del_id`,`user`.`full_name`,`photos`.`photo` FROM `deliver` join `user` join`photos` on `deliver`.`usr_name`=`user`.`usr_name` and `photos`.`photo_id`=`user`.`photo_id` WHERE `deliver`.`usr_name`='".$deliver_id. "'";
        $result1 = mysqli_query($conn, $select_cst);
        $check1 = mysqli_fetch_array($result1);
        $deliver_id=$check1['del_id'];
        $deliver_name=$check1['full_name'];
        $photo=$check1['photo'];
        $time = time();
      $date = date('Y-m-d H:i:s');
        $insert = "INSERT INTO `comment_cst`(`usr_id`,`deliver_id`,`description`,`date`,`deliver_name`,`photo`) VALUES ('".$cst_id."','".$deliver_id."','".$comment."','".$date."','".$deliver_name."','".$photo."')";
$result = mysqli_query($conn, $insert);
echo $date;
}   
else echo 0;

    
    mysqli_close($conn);

    

?>