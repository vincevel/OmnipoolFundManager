<?php
	

	class userData extends Data {
	//USER	
		
		public function getLoginDataForUser($username,$password){
			$sql = "SELECT id, account_id, first_name, last_name, admin,first_time ";
			$sql .= "FROM $this->table ";
			$sql .= "WHERE user_name='$username' and user_pass='$password'";
			
			$tempResult = $this->getCustom($sql);
			$resultRows = mysqli_num_rows($tempResult);
			
  		    if ($resultRows > 0) {
			   while($row = mysqli_fetch_assoc($tempResult)) {
			      $tempItems[] = new User($row,$resultRows);
				  $this->storeInSession($row);
			   }

		    } else {
		        //RETURN NULL USER OBJECT
		        
		        $tempArr["first_name"] = "invalidUser";
		        
		        $tempItems[] = new User($tempArr,$resultRows);
				//print "No resuult";	
			}
			//var_dump($_SESSION);
			return $tempItems;
 
		}
		
		public function checkUserNameInDb($username){
			$sql = "SELECT id ";
			$sql .= "FROM $this->table ";
			$sql .= "WHERE user_name='$username'";
			
			$tempResult = $this->getCustom($sql);
			$resultRows = mysqli_num_rows($tempResult);
			
			
			
  		    if ($resultRows > 0) {
			   while($row = mysqli_fetch_assoc($tempResult)) {
			      $tempItems[] = new User($row,$resultRows);
				  //$this->storeInSession($row);
			   }

		    } else {
		        //RETURN NULL USER OBJECT
		        
		        $tempArr["first_name"] = "invalidUser";
				$tempArr["sql"] = $sql;
		        
		        $tempItems[] = new User($tempArr,$resultRows);
				//print "No resuult";	
			}
			//var_dump($_SESSION);
			return $tempItems;
 
		}
		
		
		public function storeInSession($inputs){
			foreach ($inputs as $k => $v){
			
				//echo $k . "-" . $v . "<BR>";
				$_SESSION[$k] = $v;
			}
			
			
		}
		
		public function getAllForUser($firstName,$lastName){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT * FROM $this->table WHERE first_name='$firstName' and last_name='$lastName' ";
		  //echo $sql;
	      $tempResult = $this->getCustom($sql);
		  
		  
		  if (mysqli_num_rows($tempResult) > 0) {
			while($row = mysqli_fetch_assoc($tempResult)) {
				 $tempUsers[] = new User($row);
				 //print_r($row);
			}
		 }
		  
		  
		  return $tempUsers[0];
		
		}
		
		public function insertNewUser($query){
			$this->insertCustom($query[0],$query[1]);
		}
		
		
	}


?>