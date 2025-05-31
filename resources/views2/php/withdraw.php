<?php
    ////CHANGE TO WITHDRAWALS

    //print_r($_POST);
    echo "First Name" .$_POST["q74_name74"]["first"] . " ";
    $firstName = $_POST["q74_name74"]["first"];
     
    echo "Last Name" .$_POST["q74_name74"]["last"] . " ";
    $lastName = $_POST["q74_name74"]["last"]; 
    
    
    echo "Email" .  $_POST["q75_email75"]. " ";
    $email = $_POST["q75_email75"];
    
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
   
    $date = $_POST["q55_dateRequest"]["year"] . "-" . $_POST["q55_dateRequest"]["month"] . "-" . $_POST["q55_dateRequest"]["day"];
    echo "Date" . $date . " ";
    //$lastName = $_POST["q70_name70"]["last"]; 
   
    $amount = $_POST["q56_howMuch56"]; 
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
    $running_balance_new = $running_balance - $amount;
    
     echo $running_balance_new . " "; 
    
    $trans_type = "5254d1bc-2eb4-11e6-99a9-204747d55761";
    echo $trans_type . " ";
    
    $is_posted = 1;
    echo $is_posted . " ";
    
    $notes = $_POST["q142_instructionsTo"] . $_POST["q51_whyAre51"];
    echo "Notes" . $notes . " ";
    
    //2 TIME STAMPS
    
    
    
    //WITHDRAW TABLE
    //REUSE NOTES
    
    //change status to Pending
    $status = "Pending";
    
    $status = "Pending";
    echo "Status" . $status . " ";
    
    $requestedBy = $firstName . " " . $lastName;
    echo "RequestedBy" . $requestedBy . " ";
   
    $file_name = $_POST["temp_upload"]["q84_governmentIssued"][0];
    
    //GET DEPOSITS ID
    $sql4 ="SELECT id+1 as newid FROM `withdrawals` ORDER BY `created_at` DESC limit 1 ";
    $result4 = $mysqli->query($sql4);
    if (mysqli_num_rows($result4) > 0) {
        while($row4 = mysqli_fetch_assoc($result4)) {
               echo $row4["newid"] . " ";
                $withdrawId = $row4["newid"];
        }
    }
    
    echo "DEPOSIT ID- $depositId ";
    
    //$bankName = $_POST["q77_bankName"];
    
    
    $bankName = $_POST["q77_bankName"];
    $bankAcctNo = $_POST["q82_accountNumber"];
    $bankAcctName = $_POST["q78_bankAccount"];
    
    $notes = $notes . " " . $_POST["q79_bankBranch"] . " " . $_POST["q81_bankAccount81"] . " " . $_POST["q83_bankroutingNumber"];
    
    
    //CHECK FOR REQUIRED
    $required = 0;
    
    if (trim($_POST["q74_name74"]["first"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q74_name74"]["last"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q75_email75"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q55_dateRequest"]["month"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q55_dateRequest"]["day"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q55_dateRequest"]["year"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["q56_howMuch56"]) == NULL){
        $required = $required + 1;
    }
    
   
    
    if (trim($_POST["q78_bankAccount"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q77_bankName"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q79_bankBranch"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q81_bankAccount81"]) == NULL){
        $required = $required + 1;
    }
    
    if (trim($_POST["q82_accountNumber"]) == NULL){
        $required = $required + 1;
    }
    
     if (trim($_POST["temp_upload"]["q84_governmentIssued"][0]) == NULL){
        $required = $required + 1;
    }
    
    echo "Required - $required";
    
    
    
    
    
    
    //INSERT QUERIES
    
    $insertSql1 = "INSERT INTO `transactions`(`id`, `date_transaction`, `amount`, `running_balance`, `remarks`, `transaction_type_id`, 
    `account_id`, `is_posted`, `created_at`, `updated_at`) VALUES 
    ('$transactionId','$date','$amount','$running_balance_new','$notes','$trans_type','$accountId','$is_posted',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    
    //echo $insertSql1;
    
    $insertSql2 = "INSERT INTO `withdrawals`(`id`, `transaction_id`, `bank_name`, `bank_acct_no`, `bank_acct_name`, `user_id`, 
    `requested_by`, `email`, `notes`, `status`, `created_at`, `updated_at`) 
    VALUES ('$withdrawId','$transactionId','$bankName','$bankAcctNo','$bankAcctName','$userId','$requestedBy','$email','$notes',
    '$status',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
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
