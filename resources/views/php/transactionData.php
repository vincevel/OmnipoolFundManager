<?php


	class transactionData extends Data {	
		
		public function insertDeposit($query){
			
			//SQL QUERY GENERATION SHOULD BE DYNAMIC
			$this->insertCustom($query[0],$query[1]);
			
			//ANOTHER QUERY TO UPDATE SUBSEQUENT transactions if date is not the newest
						
		}
		
		public function insertWithdraw($query){
			
			//SQL QUERY GENERATION SHOULD BE DYNAMIC
			$this->insertCustom($query[0],$query[1]);
			
			//ANOTHER QUERY TO UPDATE SUBSEQUENT transactions if date is not the newest
						
		}
		
		public function updateLaterTransactionsForDeposits($query){
	
			$this->updateCustom($query[0],$query[1]);
		
		}
		
		public function updateLaterTransactionsForWithdraw($query){
	
			$this->updateCustom($query[0],$query[1]);
		
		}
		
		
		public function getRunningTotal($first_name,$last_name,$date){
			
			//SHOULD THIS BE BASED ON THE FIRST NAME AND LAST NAME?
			//SELECT NOW SHOULD BE BASED ON earlier transactions
			$sql = "SELECT running_balance ";
			$sql .= "FROM transactions ";
			$sql .= "WHERE first_name = '$first_name' and last_name = '$last_name'";
			$sql .= "AND date_transaction <= '$date' and testing <> 7 ";
			$sql .= "ORDER BY date_transaction DESC, created_at DESC limit 1";
			
			
			
			$sqlOrig = "SELECT running_balance 
			FROM transactions
			WHERE first_name = '$first_name' and last_name = '$last_name'
			AND testing <> 7
            ORDER BY date_transaction,created_at desc limit 1";
			echo $sql;
			$tempResult = $this->getCustom($sql);
			
			return $this->processResult($tempResult);
			
		}
		
		public function checkForLaterTransactions($transaction){
			
			//SHOULD THIS BE BASED ON THE FIRST NAME AND LAST NAME?
			//SELECT NOW SHOULD BE BASED ON earlier transactions
			$sql = "SELECT COUNT(*) as rowNum ";
			$sql .= "FROM transactions ";
			$sql .= "WHERE first_name = '$transaction->first_name' and last_name = '$transaction->last_name'";
			$sql .= "AND date_transaction > '$transaction->date_transaction' and testing <> 7 ";
			$sql .= "ORDER BY date_transaction DESC limit 1";
			
			echo $sql;
			
			$tempResult = $this->getCustom($sql);
			
			$tempResult2 = $this->processResult($tempResult);
			
			return $tempResult2[0]->rowNum;
		}
		
		public function getRunningTotalForDeposit($transaction){
		   
			$tempResultObjects = $this->getRunningTotal($transaction->first_name,$transaction->last_name,$transaction->date_transaction);
			//ALWAYS ONE RESULT SO INDEX 0
			$tempAmount = $tempResultObjects[0]->running_balance;
			
			//RETURNS DOUBLE
			//return $this->amount + $tempAmount;     
			$transaction->running_balance = $tempAmount + $transaction->amount;
			
		}
		
		public function getRunningTotalForWithdraw($transaction){
		   
			$tempResultObjects = $this->getRunningTotal($transaction->first_name,$transaction->last_name,$transaction->date_transaction);
			//ALWAYS ONE RESULT SO INDEX 0
			$tempAmount = $tempResultObjects[0]->running_balance;
			
			//RETURNS DOUBLE
			//return $this->amount  $tempAmount;     
			$transaction->running_balance = $tempAmount - $transaction->amount;
			
		}
		
		

		public function getTransactionDataForUser($firstName,$lastName){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, running_balance, remarks, transaction_type_id FROM transactions where `last_name` = '$lastName' and `first_name` = '$firstName' ORDER BY  date_transaction ASC, created_at ASC ";
		  
		  //echo $sql;
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult); 
			
		}//END FUNC
		
		
		public function getTransactionDataForUserWithDate($firstName,$lastName,$startDate,$endDate){
		  //FETCH ALL DATA-ROWS WITH DATE
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, running_balance, remarks, transaction_type_id FROM transactions where `last_name` = '$lastName' and `first_name` = '$firstName' and date_transaction BETWEEN '$startDate' AND '$endDate' ORDER BY `date_transaction` ASC";
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult);
			
		  //return $tempItems; 
			
		}//END FUNC

		public function getDepositsForAll(){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT id, first_name, last_name, date_transaction, amount, notes, status FROM transactions where transaction_type_id='1' ORDER BY `date_transaction` ASC  ";
	      
	      //echo $sql;
	     
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult); 
			
		}//END FUNC
		
		public function getDepositsForAllWithDate($startDate,$endDate){
		  //FETCH ALL DATA-ROWS WITH DATE
		  
		  
		  $sql ="SELECT id, first_name, last_name, date_transaction, amount, notes, status  FROM transactions where transaction_type_id='1' AND date_transaction BETWEEN '$startDate' AND '$endDate' ORDER BY `date_transaction` ASC";
		  //echo $sql;
		  
		  
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult);
			
		  //return $tempItems; 
			
		}//END FUNC
		
		public function getWithdrawalsForAll(){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT id, first_name, last_name, date_transaction, amount, notes, status FROM transactions where transaction_type_id='3' ORDER BY `date_transaction` ASC  ";
	      //echo $sql;
	     
	      $tempResult = $this->getCustom($sql);
			
  		  return $this->processResult($tempResult); 
			
		}//END FUNC
		
		public function getWithdrawalsForAllWithDate($startDate,$endDate){
		  //FETCH ALL DATA-ROWS WITH DATE
		  
		  $sql ="SELECT id, first_name, last_name, date_transaction, amount, notes, status  FROM transactions where transaction_type_id='3' AND date_transaction BETWEEN '$startDate' AND '$endDate' ORDER BY `date_transaction` ASC";
		  //echo $sql;
		  
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
					
				$tempTransaction["first_name"] = "Invalid Transaction";
				$tempItems[] = new Transaction($tempTransaction);
					 
				//print "No resuult";	
			}
			
			return $tempItems;
			
		}//END FUNC
	}//END CLASS


?>