<?php

	class Transaction {
		
	
		public function __construct($inputs){
			
			
			foreach ($inputs as $k => $v){
			
				//echo $k . "-" . $v . "<BR>";
				$this->$k = $v;
			}
			
			//$this->rows = $rows;
			
		}
	
	}
	
?>