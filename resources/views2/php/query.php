<?php

    //print "hello";
    
    //print_r($_POST);
    //print_r($_POST['firstName']);

    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    
try{
$mysqli = new mysqli("127.0.0.1", "vincerap7132_testing1", "Test013020#", "vincerap7132_testing");
      
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
     
    $sql = "SELECT first_name, last_name, user_id from users where first_name='$firstName' and last_name='$lastName' "; 
    //$sql = "SELECT * `testing` (`first`, `second`, `third`, `fourth`) VALUES ('5', '3', '6', '2')";
  
    echo $sql;
    $result = $mysqli->query($sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
               echo $row["user_id"];
               //echo '1111';
        }
    }
    
    echo mysqli_num_rows($result);
    
    /* 
    if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               echo "Name: " . $row["user_id"];
            }
         } else {
            echo "0 results";
    }
    */
    
} catch (Exception $e){
   //echo 'Caught exception: ',  $e->getMessage(), "\n";
   print_r($e);
}


 

//  print "hello2";




?>
