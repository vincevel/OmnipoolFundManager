<?php

	class Transaction {
		
		private $requiredFields = array("first_name","last_name","date_transaction","amount","file_name");
	
		public function __construct($inputs){
	
			foreach ($inputs as $k => $v){
				//echo "$k Here $v \n";
				$this->$k = $v;
				
				$this->requiredFields[] = $k;
			}
		}
		
		public function setRequiredFields($input){
			
			$this->requiredFields = $input;
		}
		
		public function checkRequiredFields(){
		
			$required = 0;
			
			foreach ($this->requiredFields as $item){	
				if (trim($this->$item) == NULL){
        			$required = $required + 1;
    			}
			
			}
		
			return $required > 0 ? false : true;
		
		}
		
		public function setAdditionalData(){
			
			$this->user_id = $_SESSION["id"];
			$this->account_id = $_SESSION["account_id"];
			$this->transaction_type_id = 1; 
			$this->is_posted = 1;
			$this->remarks = $this->notes;
			$this->status = "Pending";
			$this->requested_by = "{$this->first_name} {$this->last_name}";
			//$this->running_balance = 1;
			//TIMESTAMP GENERATED AUTO BY MYSQL
			
		}
		
		public function setAdditionalDataWithdraw(){
			
			$this->user_id = $_SESSION["id"];
			$this->account_id = $_SESSION["account_id"];
			$this->transaction_type_id = 3; 
			$this->is_posted = 1;
			$this->remarks = $this->notes;
			$this->status = "Pending";
			$this->requested_by = "{$this->first_name} {$this->last_name}";
			//$this->running_balance = 1;
			//TIMESTAMP GENERATED AUTO BY MYSQL
			
		}
		
		
		public function buildUpdateSql($transaction){
			
			//UPDATE running_balance add amount
			
			
			$sql = "UPDATE transactions ";
			$sql .= "SET running_balance=running_balance+? ";
			$sql .= "WHERE date_transaction > ? ";
			$sql .= "AND first_name=? AND last_name=?"; 
			
			$format = 'ssss';
				
			
			$params[0]= &$format;
			$params[1]= &$transaction->amount;
			$params[2]= &$transaction->date_transaction;
			$params[3]= &$transaction->first_name;
			$params[4]= &$transaction->last_name;
			
			
			return array($sql,$params);
			//var_dump($sql);0
		
		}
		
		public function buildUpdateSqlWithdraw($transaction){
			
			//UPDATE running_balance add amount
			
			
			$sql = "UPDATE transactions ";
			$sql .= "SET running_balance=running_balance-? ";
			$sql .= "WHERE date_transaction > ? ";
			$sql .= "AND first_name=? AND last_name=?"; 
			
			$format = 'ssss';
				
			
			$params[0]= &$format;
			$params[1]= &$transaction->amount;
			$params[2]= &$transaction->date_transaction;
			$params[3]= &$transaction->first_name;
			$params[4]= &$transaction->last_name;
			
			
			return array($sql,$params);
			//var_dump($sql);0
		
		}
		
		
		public function buildInsertSql($format = ""){
			
			$format = '';
			$params[0]= &$format;
			
			foreach ($this as $k => $v){
				if ($k != "requiredFields"){
				    $format .= "s";
				    $columns[] = $k;	
			        $count[] = "?";
					$params[] = &$this->$k;
				
				}
			}
			
			$fullColumns = implode(",",$columns);
			$fullCount = implode(",",$count);
		    
			
			$query = "INSERT INTO transactions ($fullColumns) VALUES ($fullCount)";
			
			//var_dump($query,$params);
			return array($query,$params);
		}
	
	}
	
?>