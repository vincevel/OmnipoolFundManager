<?php
 


	//GENERIC MODEL CLASS FOR DATABASE TABLE
class Data {
var $transactions = array();

	
	public function __construct($table){
	//place all POST vars into object
	
		//INITIALIZE SPECIFIC TABLE
		$this->table = $table;
	
		//CONNECT TO DB
		try{
	      //PARAMETERIZE LATER
		  $mysqli = new mysqli("127.0.0.1", "vincerap7132_testing1", "Test013020#", "vincerap7132_testing");
          if ($mysqli->connect_errno) {
		  	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		  } else {
		 	$this->dbconn = $mysqli;
		  }
		
		} catch (Exception $e){
  		 //echo 'Caught exception: ',  $e->getMessage(), "\n";
   			print_r($e);
		}
		
	}


	public function getAll(){
		  //FETCH ALL DATA-ROWS
		  
		  $sql ="SELECT * FROM $this->table";
	      $result = $this->dbconn->query($sql);

		  if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				 print_r($row);
			}
		 }
			
	}
	
	public function dbClose(){
		$this->dbconn->close();

	}
	
	
	public function getCustom($sqlInput){
		  //FETCH ALL DATA-ROWS with custom sql
		  $result = $this->dbconn->query($sqlInput);

		 //var_dump($transactions);		
		  return $result;
	}
	
	public function insertCustom($sql,$params){
		
		if($stmt = $this->dbconn->prepare($sql)){;
			
			//Params are references
			call_user_func_array( array($stmt, 'bind_param'), $params); 
			
			try {	
			$stmt->execute();
			} catch (Exception $e) {
				var_dump($e);	
			}
			printf("%d Row inserted.\n", $stmt->affected_rows);	
			printf("Error: %s\n", $this->dbconn->error);
		} else {
			printf("Error: %s\n", $this->dbconn->error);
		}
	}	
	
	public function updateCustom($sql,$params){
		//var_dump($sql,$params);
		
		
		if($stmt = $this->dbconn->prepare($sql)){
			
			//Params are references
			call_user_func_array( array($stmt, 'bind_param'), $params); 
			
			try {
				$stmt->execute();
			} catch (Exception $e) {
				var_dump($e);	
			}
			
			printf("%d Row inserted.\n", $stmt->affected_rows);	
		} else {
	    	printf("Error: %s\n", $this->dbconn->error);
		}
	}	

	
}




?>