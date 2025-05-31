<?php


	class transactionData extends Data {
		

		public function getTransactionDataForUser($firstName,$lastName){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, running_balance, remarks, transaction_type_id FROM transactions where `last_name` = '$lastName' and `first_name` = '$firstName' ORDER BY      `date_transaction` ASC  ";
	      echo $sql;
	     
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult); 
			
		}//END FUNC
		
		
		public function getTransactionDataForUserWithDate($firstName,$lastName,$startDate,$endDate){
		  //FETCH ALL DATA-ROWS WITH DATE
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, running_balance, remarks, transaction_type_id FROM transactions where `last_name` = '$lastName' and `first_name` = '$firstName' and date_transaction BETWEEN '$startDate' AND '$endDate' ORDER BY `date_transaction` ASC";
		  echo $sql;
		  
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult);
			
		  //return $tempItems; 
			
		}//END FUNC
		
		public function getDepositsForAll(){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, notes, status FROM transactions where transaction_type_id='1' ORDER BY `date_transaction` ASC  ";
	      
	      //echo $sql;
	     
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult); 
			
		}//END FUNC
		
		public function getDepositsForAllWithDate($startDate,$endDate){
		  //FETCH ALL DATA-ROWS WITH DATE
		  
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, notes, status  FROM transactions where transaction_type_id='1' AND date_transaction BETWEEN '$startDate' AND '$endDate' ORDER BY `date_transaction` ASC";
		  //echo $sql;
		  
		  
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult);
			
		  //return $tempItems; 
			
		}//END FUNC
		
		public function getWithdrawalsForAll(){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, notes, status FROM transactions where transaction_type_id='3' ORDER BY      `date_transaction` ASC  ";
	      echo $sql;
	     
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult); 
			
		}//END FUNC
		
		public function getWithdrawalsForAllWithDate($startDate,$endDate){
		  //FETCH ALL DATA-ROWS WITH DATE
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, notes, status  FROM transactions where transaction_type_id='3' AND date_transaction BETWEEN '$startDate' AND '$endDate' ORDER BY `date_transaction` ASC";
		  echo $sql;
		  
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult);
			
		  //return $tempItems; 
			
		}//END FUNC
		
		public function processResult($result){
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$tempItems[] = new Transaction($row);
					//print_r($row);
				}
			} else {
					
				//$tempTransaction["first_name"] = "Invalid Transaction";
				//$tempItems[] = new Transaction($tempTransaction);
					 
				//print "No resuult";	
			}
			
			return $tempItems;
			
		}//END FUNC
	}//END CLASS


?>