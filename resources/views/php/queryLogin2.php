<?php
    //CATCH VARIABLES
    //print_r($_POST);

    $userName = trim($_POST['userName']);
    $password = trim($_POST['password']);
    
    
try{
    $mysqli = new mysqli("127.0.0.1", "vincerap7132_testing1", "Test013020#", "vincerap7132_testing");
    $returnArr = array();  
      
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
     
    $sql = "SELECT user_name, id,  first_time, admin from users where user_name='$userName' and password='$password' "; 
    //echo $sql;
    
    $result = $mysqli->query($sql);

    $returnArr['rows'] = mysqli_num_rows($result);
    
    //GET USER ID
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
                $user_id = $row["id"];
            
                $returnArr['firstTime'] = $row["first_time"];
                $returnArr['admin'] = $row["admin"];
        }
    
        
    
    
        $sql2 = "SELECT first_name, last_name from users where user_id='$user_id' ";     
        $result2 = $mysqli->query($sql2);
        
        if (mysqli_num_rows($result2) > 0) {
            while($row2 = mysqli_fetch_assoc($result2)) {
                $returnArr["firstName"] = $row2["first_name"];
                $returnArr["lastName"] = $row2["last_name"];
              
            }
        }
        
    }
    
    
    
    
    echo json_encode($returnArr);

   
} catch (Exception $e){
   //echo 'Caught exception: ',  $e->getMessage(), "\n";
   print_r($e);
}

?>
