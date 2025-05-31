<?php


	class transactionData extends Data {	
		
		public function insertDeposit($query){
			
			//SQL QUERY GENERATION SHOULD BE DYNAMIC
			$this->insertCustom($query[0],$query[1]);
						
		}
		
		public function getRunningTotal($first_name,$last_name){
			
			//SHOULD THIS BE BASED ON THE FIRST NAME AND LAST NAME?
			$sql = "SELECT running_balance 
			FROM transactions
			WHERE first_name = '$first_name' and last_name = '$last_name'
			AND testing <> 7
            ORDER BY date_transaction desc limit 1";
			//echo $sql;
			$tempResult = $this->getCustom($sql);
			
			return $this->processResult($tempResult);
			
		}
		
		public function getRunningTotalForDeposit($transaction){
		   
			$tempResultObjects = $this->getRunningTotal($transaction->first_name,$transaction->last_name);
			//ALWAYS ONE RESULT SO INDEX 0
			$tempAmount = $tempResultObjects[0]->running_balance;
			
			//RETURNS DOUBLE
			//return $this->amount + $tempAmount;     
			$transaction->running_balance = $tempAmount + $transaction->amount;
			
		}
		
		public function getRunningTotalForWithdraw($transaction){
		   
			$tempResultObjects = $this->getRunningTotal($transaction->first_name,$transaction->last_name);
			//ALWAYS ONE RESULT SO INDEX 0
			$tempAmount = $tempResultObjects[0]->running_balance;
			
			//RETURNS DOUBLE
			//return $this->amount + $tempAmount;     
			$transaction->running_balance = $tempAmount - $transaction->amount;
			
		}

		public function getTransactionDataForUser($firstName,$lastName){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT first_name, last_name, date_transaction, amount, running_balance, remarks, transaction_type_id FROM transactions where `last_name` = '$lastName' and `first_name` = '$firstName' ORDER BY      `date_transaction` ASC  ";
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
		
		public function processResult($result){
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$tempItems[] = new Transaction($row);
					//print_r($row);
				}
				
				//var_dump($tempItems);
			} else {
					
				$tempTransaction["first_name"] = "Invalid Transaction";
				$tempItems[] = new Transaction($tempTransaction);
					 
				//print "No resuult";	
			}
			
			return $tempItems;
			
		}//END FUNC
	}//END CLASS


?>