<?php

	class User {
		
		 
		private $requiredFields = array("user_name","first_name","middle_name","last_name","phone_no","user_pass","user_email","country","beneficiary1_middle_name","beneficiary1_last_name","id_number","date_issue","place_issue","govt_id_pic");
	
		public function __construct($inputs, $rows=""){
			
			
			
			foreach ($inputs as $k => $v){
			
				//echo $k . "-" . $v . "<BR>";
				$this->$k = $v;
				
				//$this->requiredFields[] = $k;
			}
			
			$this->rows = $rows;
			
		}
	
		public function buildInsertSql($format = ""){
			
			$format = '';
			$params[0]= &$format;
			
			foreach ($this as $k => $v){
				
				switch ($k){
					case "requiredFields":
					case "rows":
						break;
					default:
						$format .= "s";
						$columns[] = $k;	
						$count[] = "?";
						$params[] = &$this->$k;
						
					
					
				}
				/*
				if ($k != "requiredFields" || $k != "rows"){
				    $format .= "s";
				    $columns[] = $k;	
			        $count[] = "?";
					$params[] = &$this->$k;
				
				}
				*/
			}
			
			$fullColumns = implode(",",$columns);
			$fullCount = implode(",",$count);
		    
			
			$query = "INSERT INTO users ($fullColumns) VALUES ($fullCount)";
			
			//var_dump($query,$params);
			return array($query,$params);
		}
		
		public function checkRequiredFields(){
		
			$required = 0;
			
			foreach ($this->requiredFields as $item){	
				if (trim($this->$item) == NULL){
					var_dump($item);
        			$required = $required + 1;
    			}
			
			}
		
			return $required > 0 ? false : true;
		
		}
	
	
	}
	
?>