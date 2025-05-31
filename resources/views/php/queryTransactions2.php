<?php
    print_r($_POST);
    //print_r($_POST['firstName']);
    //print "really";
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    
    $startDate = trim($_POST['startDate']);
    $endDate = trim($_POST['endDate']);
    
    /*
    $startDate = "03-10-2015";
    $endDate = "03-17-2021";
    $firstName = "diane";
    $lastName = "lumbao";
    */
try{
$mysqli = new mysqli("127.0.0.1", "vincerap7132_testing1", "Test013020#", "vincerap7132_testing");
      
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
     
    if ($startDate != NULL){
     $startDate2 = explode("-", $startDate);
     $startDate3 = $startDate2[2] . "-". $startDate2[0] . "-" . $startDate2[1] . " 00:00:00";
     
     $endDate2 = explode("-", $endDate);
     $endDate3 = $endDate2[2] . "-". $endDate2[0] . "-" . $endDate2[1] . " 23:59:59";
  
     $sql = "SELECT A.`first_name`, A.`last_name`, B.date_transaction, B.amount, B.running_balance, B.remarks, C.code FROM `clients` A, 
     transactions B, transaction_types C WHERE A.account_id = B.account_id and B.transaction_type_id = C.id and 
     A.`first_name` = '$firstName' and A.`last_name` = '$lastName' and B.date_transaction BETWEEN '$startDate3' AND '$endDate3'  
     ORDER BY `B`.`date_transaction` ASC ";
     }


    
     if ($startDate == NULL){
    
     //$sql = "SELECT A.`first_name`, A.`last_name`, B.date_transaction, B.amount, B.running_balance, B.remarks, C.code FROM `clients` A, 
     //transactions B, transaction_types C WHERE A.account_id = B.account_id and B.transaction_type_id = C.id and 
     //A.`first_name` = '$firstName' and A.`last_name` = '$lastName' ORDER BY `B`.`date_transaction` ASC ";

     $sql = "SELECT first_name, last_name, date_transaction, amount, running_balance, remarks, transaction_type_id FROM transactions where `last_name` = '$lastName' and `first_name` = '$firstName' ORDER BY      `date_transaction` ASC  ";

    echo $sql;
     }
    
    echo "<table border=1>";
    
    echo "<tr> ";
    echo "<td>First Name</td>";
    echo "<td>Last Name</td>";
    echo "<td>Date Of Transaction</td>";
    echo "<td>Amount</td>";
    echo "<td>Running Balance</td>";
    echo "<td>Remarks</td>";
    echo "<td>Code</td>";
    echo " </tr>";
    
    foreach ( $mysqli->query($sql) as $row ) {
    
    
    
        echo "<tr> ";
            foreach ($row as $k => $v){
               
               
                echo "<td>$v</td>";
                
            }
        
        
        echo " </tr>";
        
    } 
     
    echo "</table>";
     
    
$resource->free();
$db->close();
    
} catch (Exception $e){
   //echo 'Caught exception: ',  $e->getMessage(), "\n";
   print_r($e);
}






?>
