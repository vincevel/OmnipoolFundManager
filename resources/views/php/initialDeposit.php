<?php
   //CHANGE TO DEPOSITS
   
   
    //print_r($_POST);
    echo "First Name" .$_POST["q70_name70"]["first"] . " ";
    $firstName = $_POST["q70_name70"]["first"];
     
    echo "Last Name" .$_POST["q70_name70"]["last"] . " ";
    $lastName = $_POST["q70_name70"]["last"]; 
     
    
try{
    
    
$mysqli = new mysqli("127.0.0.1", "vincerap7132_testing1", "Test013020#", "vincerap7132_testing");
      
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
   
    //GET ACCOUNT ID
    
    $sql1 ="SELECT account_id, user_id FROM clients WHERE first_name='$firstName' and last_name ='$lastName' ";
    
    $result1 = $mysqli->query($sql1);

    if (mysqli_num_rows($result1) > 0) {
        while($row1 = mysqli_fetch_assoc($result1)) {
               echo $row1["account_id"] . " ";
               $accountId = $row1["account_id"];
               echo $row1["user_id"] . " ";
               $userId = $row1["user_id"];
        }
    }
    
    
    
    
    
    //GET TRANSACTION ID
    $sql2 ="SELECT id+1 as newid FROM `transactions` ORDER BY `created_at` DESC limit 1";
    
    $result2 = $mysqli->query($sql2);
    
    if (mysqli_num_rows($result2) > 0) {
        while($row2 = mysqli_fetch_assoc($result2)) {
               echo $row2["newid"] . " ";
                $transactionId = $row2["newid"];
        }
    }
   
    $date = $_POST["q41_whenDid"]["year"] . "-" . $_POST["q41_whenDid"]["month"] . "-" . $_POST["q41_whenDid"]["day"];
    echo "Date" . $date . " ";
    //$lastName = $_POST["q70_name70"]["last"]; 
   
    $amount = $_POST["q40_howMuch40"]; 
    echo "Amount" . $amount . " ";
    
    //GET RUNNING TOTAL
    
    $sql3 = "SELECT  B.running_balance FROM `clients` A, 
     transactions B, transaction_types C WHERE A.account_id = B.account_id and B.transaction_type_id = C.id and 
     A.`first_name` = '$firstName' and A.`last_name` = '$lastName'
     ORDER BY `B`.`date_transaction` desc limit 1";
    
    $result3 = $mysqli->query($sql3);
    
    if (mysqli_num_rows($result3) > 0) {
        while($row3 = mysqli_fetch_assoc($result3)) {
               echo $row3["running_balance"] . " ";
                $running_balance = $row3["running_balance"];
        }
    }
    $running_balance_new = $running_balance + $amount;
     echo $running_balance_new . " "; 
    
    $trans_type = "52467cfc-2eb4-11e6-b50a-204747d55761";
    echo $trans_type . " ";
    
    $is_posted = 1;
    echo $is_posted . " ";
    
    $notes = $_POST["q143_instructionsTo143"];
    echo "Notes" . $notes . " ";
    
    //2 TIME STAMPS
    
    
    
    //DEPOSITS TABLE
    //REUSE NOTES
    //change status to Pending
    $status = "Pending";
    echo "Status" . $status . " ";
    
    $requestedBy = $firstName . " " . $lastName;
    echo "RequestedBy" . $requestedBy . " ";
   
    $file_name = $_POST["temp_upload"]["q42_uploadA"][0];
    
    //GET DEPOSITS ID
    $sql4 ="SELECT id+1 as newid FROM `deposits` ORDER BY `created_at` DESC limit 1 ";
    $result4 = $mysqli->query($sql4);
    if (mysqli_num_rows($result4) > 0) {
        while($row4 = mysqli_fetch_assoc($result4)) {
               echo $row4["newid"] . " ";
                $depositId = $row4["newid"];
        }
    }
    
    echo "DEPOSIT ID- $depositId ";
    
    
    //CHECK FOR REQUIRED
    $required = 0;
    
    if (trim($_POST["q70_name70"]["first"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q70_name70"]["last"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q71_email71"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q41_whenDid"]["month"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q41_whenDid"]["day"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q41_whenDid"]["year"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q40_howMuch40"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q143_instructionsTo143"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["temp_upload"]["q42_uploadA"][0]) == NULL){
        $required = $required + 1;
    }
    
    echo "Required - $required";
    
    //INSERT QUERIES
    
    $insertSql1 = "INSERT INTO `transactions`(`id`, `date_transaction`, `amount`, `running_balance`, `remarks`, `transaction_type_id`, 
    `account_id`, `is_posted`, `created_at`, `updated_at`) VALUES 
    ('$transactionId','$date','$amount','$running_balance_new','$notes','$trans_type','$accountId','$is_posted',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    
    //echo $insertSql1;
    
    $insertSql2 = "INSERT INTO `deposits`(`id`, `transaction_id`, `status`, `notes`, `file_name`, `user_id`, 
    `requested_by`, `created_at`, `updated_at`) 
    VALUES ('$depositId','$transactionId','$status','$notes','$file_name','$userId','$requestedBy',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    //echo $insertSql2;
    if (!$required > 0){
        $result1 = $mysqli->query($insertSql1);
        $result2 = $mysqli->query($insertSql2);
    }
    
} catch (Exception $e){
   //echo 'Caught exception: ',  $e->getMessage(), "\n";
   print_r($e);
}






?>
