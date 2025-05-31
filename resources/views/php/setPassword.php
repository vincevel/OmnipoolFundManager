<?php
    //print_r($_POST);
    $userName = trim($_POST['userName']);
    $password = trim($_POST['password']);
    
try{
$mysqli = new mysqli("127.0.0.1", "vincerap7132_testing1", "Test013020#", "vincerap7132_testing");
    
    $returnArr = array();
      
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
     
    //$sql = "SELECT first_name, last_name, user_id from clients where first_name='$firstName' and last_name='$lastName' "; 
    $sql = "UPDATE users SET password = '$password' WHERE id = '$userName'"; 
    //echo $sql;
   
    $returnArr["result"] = $mysqli->query($sql);

    $sql2 = "SELECT user_name from users where id ='$userName' ";
    
    $result = $mysqli->query($sql2);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
               $returnArr["user_name"] = $row["user_name"];
        }
    }


    //echo $result;
    echo json_encode($returnArr);
    

} catch (Exception $e){
   //echo 'Caught exception: ',  $e->getMessage(), "\n";
   print_r($e);
}


 

//  print "hello2";




?>
