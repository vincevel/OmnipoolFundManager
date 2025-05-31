<?php
header("content-type: text/html; charset=UTF-8"); 
    
    //print_r($_POST);
    //print_r($_POST['firstName']);



    //$firstName = trim($_POST['firstName']);
    //$lastName = trim($_POST['lastName']);
    
    $startDate = trim($_POST['startDate']);
    $endDate = trim($_POST['endDate']);
    
    
    //$startDate = "01-01-2017";
    //$endDate = "12-31-2017";
    //$firstName = "diane";
   // $lastName = "lumbao";
    
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
  
     $sql = "SELECT A.`first_name`, A.`last_name`, B.date_transaction, B.amount, C.notes, C.transaction_id, C.status FROM `clients` A, transactions B, deposits C WHERE A.account_id = B.account_id and B.id = C.transaction_id  
and B.date_transaction BETWEEN '$startDate3' AND '$endDate3' 
ORDER BY `B`.`date_transaction`  ASC  limit 1000  ";
     }


    
     if ($startDate == NULL){
    
     $sql = "SELECT A.`first_name`, A.`last_name`, B.date_transaction, B.amount, C.notes, C.transaction_id, C.status  FROM `clients` A, transactions B, deposits C WHERE A.account_id = B.account_id and B.id = C.transaction_id  
ORDER BY `B`.`date_transaction`  ASC  limit 1000 ";

     }
    
    echo "<table border=1>";
    
    echo "<tr> ";
    echo "<td>First Name</td>";
    echo "<td>Last Name</td>";
    echo "<td>Date Of Transaction</td>";
    echo "<td>Amount</td>";
    echo "<td>Notes</td>";
    echo "<td>Status</td>";
    echo " </tr>";
    
    foreach ( $mysqli->query($sql) as $row ) {
    
    
    
        echo "<tr> ";
        //print_r($row);//echo "{$row['field']}";
            foreach ($row as $k => $v){
               // first_name		last_name		date_transaction		amount		transaction_id	status	Cancelled
               //echo "<td>$k</td>";
                if ($k == "transaction_id"){
          
                    $temp_transaction = $v;
                }
                
                 if ($k == "first_name"){
                    //firstName
                    $temp_firstName = $v;
                }
                
                if ($k == "last_name"){
                    //lastName
                    $temp_lastName = $v;
                }
            
                if ($k == "date_transaction"){
                    //dateOf
                    $temp_dateTransaction = $v;
                }
            
                if ($k == "amount"){
                    //amount
                    $temp_amount= $v;
                }
            
            
                if ($k == "status"){
                    
                    if ($v == "Verified"){
                        
                        echo "<td>$v</td>";
                    }else{
                    echo "<td><a href=\"https://form.jotform.me/91284364186463?transactionId=$temp_transaction&firstName=$temp_firstName&lastName=$temp_lastName&dateOf=$temp_dateTransaction&amount=$temp_amount\" target=\"_blank\" >$v</a></td>";
                    }
                }else{
                     if ($k != "transaction_id"){
                     echo "<td>$v</td>";
                     }
                    
                }
                
               
                
            }
        
        
        echo " </tr>";
        //echo "<BR>";
    } 
     
    echo "</table>";
     
    
    
$resource->free();
$db->close();
    
} catch (Exception $e){
   //echo 'Caught exception: ',  $e->getMessage(), "\n";
   print_r($e);
}






?>
