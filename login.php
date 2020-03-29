<?php

$servername = "localhost";
$username = "root";
$password = '';
$conn = mysqli_connect($servername, $username, $password, "test");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$usr_name=$obj['usr_name'];
$password=$obj['password'];
if ($conn->connect_error) 
    {
        echo "Connection failed: " . $conn->connect_error;
    }

    else 
    {
$select="SELECT `usr_name` FROM `user` WHERE `usr_id`='".$usr_name."'";
if(mysqli_query($conn,$select)){
    return(false);
}
        $SQL = "SELECT `usr_name`, `password`,`type` FROM `user` WHERE `usr_name`='".$usr_name."' AND `password`='".$password."'";
        
        $result = mysqli_query($conn, $SQL);
        $check = mysqli_fetch_array($result);

      //  echo $conn->error;
        if (!isset($check))
        {
            $emailnotExist = 0;
	 
            // Converting the message into JSON format.
           $notexistEmailJSON = json_encode($emailnotExist);
            
           // Echo the message on Screen.
            echo $notexistEmailJSON ; 
       
        }
        else {
            if($check['type']=='customer')
        {
            $emailExist = 1;
	 
          }
        else if($check['type']=='deliver')
        {
            $emailExist = 2;
	 
        }
        else if($check['type']=='seller')
        {
            $emailExist = 3;
	         }
        else {
            $emailExist=4;
        }
        $existEmailJSON = json_encode($emailExist);
            
        // Echo the message on Screen.
         echo $existEmailJSON ; 
    }
        
    }
 mysqli_close($conn);

?>