<?php
	session_start();
	
	include 'transaction.php';

	include 'data.php';
	include 'transactionData.php';
	
    //var_dump($_POST);
	//var_dump($_SESSION);
	//INPUTS
	$firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    
    $startDate = trim($_POST['startDate']);
    $endDate = trim($_POST['endDate']);
    
	$checked = $_POST['checked'];
	$action = $_POST['action'];
    /*
	$startDate = "01-01-2018";
    $endDate = "12-31-2018";
	
	$firstName = trim("diane");
    $lastName = trim("lumbao");
    */ 
	
	class transactionsController 
	{
		public function __construct(){}
	
		public function getTransactionsForUser($firstName,$lastName){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$transactionData = new TransactionData("transactions");
			$temp = $transactionData->getTransactionDataForUser($firstName,$lastName);					
			return $temp;
		}
		
		
		public function getTransactionsForUserWithDate($firstName,$lastName,$startDate,$endDate){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$transactionData = new TransactionData("transactions");
			$temp = $transactionData->getTransactionDataForUserWithDate($firstName,$lastName,$startDate,$endDate);					
			return $temp;
		}
		
		public function getDepositsForAll(){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$transactionData = new TransactionData("transactions");
			$temp = $transactionData->getDepositsForAll();					
			return $temp;
		}
		
		public function getDepositsForAllWithDate($startDate,$endDate){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$transactionData = new TransactionData("transactions");
			$temp = $transactionData->getDepositsForAllWithDate($startDate,$endDate);					
			return $temp;
		}
		
		public function getWithdrawalsForAll(){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$transactionData = new TransactionData("transactions");
			$temp = $transactionData->getWithdrawalsForAll();					
			return $temp;
		}
		
		public function getWithdrawalsForAllWithDate($startDate,$endDate){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$transactionData = new TransactionData("transactions");
			$temp = $transactionData->getWithdrawalsForAllWithDate($startDate,$endDate);					
			return $temp;
		}
		
		public function generateStartDate($date){
			$date2 = explode("-", $date);
    		$startDate = $date2[2] . "-". $date2[0] . "-" . $date2[1] . " 00:00:00";
		    
			return $startDate;
     	 
     	}

		public function generateEndDate($date){
			
			$date2 = explode("-", $date);
     		$endDate = $date2[2] . "-". $date2[0] . "-" . $date2[1] . " 23:59:59";
     		return $endDate;
     		
		}
	
		
		
		public function returnResponse($response){
			foreach ($response as $item){
				//echo json_encode($item);
				//var_dump($item);
			}
			
		}
		
		public function generateTransactionCode($code){
		    
		    switch ($code) {
					    
    		    case "1":
                $item="<td>DP</td>";
    			break;
    					    
    			case "2":
                $item="<td>DV</td>";
    		    break;
    					          
    			case "3":
                $item="<td>WD</td>";
    			break;
    					          
    			case "4":
                $item="<td>MF</td>";
    			break;
    					          
    			case "5":
                $item="<td>AF</td>";
    			break;
					    
		    }
		    
		    return $item;
		}
		
		public function returnHtmlResponse($response){
			 
			echo "<table class=\"table-sm table-hover table-bordered table-striped\">";
			echo "<tr>";
			echo "<td class=\"bg-success text-white\">First Name</td>";
			echo "<td class=\"bg-success text-white\">Last Name</td>";
			echo "<td class=\"bg-success text-white\">Date Of Transaction</td>";
			echo "<td class=\"bg-success text-white\">Amount</td>";
			echo "<td class=\"bg-success text-white\">Running Balance</td>";
			echo "<td class=\"bg-success text-white\">Remarks</td>";
			echo "<td class=\"bg-success text-white\">Code</td>";
			echo " </tr>";
		
			foreach ( $response as $row ) {
			echo "<tr> ";
				foreach ($row as $k => $v){
					
					switch ($k){
						
						case "transaction_type_id":
							echo $this->generateTransactionCode($v);
							$current_code = $v;
							break;
						
						default:
							echo "<td>$v</td>";
				
				
					}
				
				}
			echo " </tr>";
			} 
		 
			echo "</table>";
		
			
		}
		
		public function returnHtmlResponseDeposit($response){
			//id, first_name, last_name, date_transaction, amount, notes, status
			echo "<table class=\"table-sm table-hover table-bordered table-striped\">";
			echo "<tr> ";
			echo "<td class=\"bg-success text-white\">First Name</td>";
			echo "<td class=\"bg-success text-white\">Last Name</td>";
			echo "<td class=\"bg-success text-white\">Date Of Transaction</td>";
			echo "<td class=\"bg-success text-white\">Amount</td>";
			echo "<td class=\"bg-success text-white\">Notes</td>";
			echo "<td class=\"bg-success text-white\">Status</td>";
			echo " </tr>";
			
			foreach ( $response as $row ) {
			
			$id = $row->id;
			$first_name = $row->first_name;
			$last_name = $row->last_name;
			$date_transaction = $row->date_transaction;
			$amount = $row->amount;
			// = $row;
			
			echo "<tr> ";
				foreach ($row as $k => $v){
					
					switch ($k){
						case "id":
							break;
						case "status":
							switch ($v){
								case "Pending":
									echo "<td><a href=\"https://form.jotform.me/91284364186463?transactionId=$id&firstName=$first_name&lastName=$last_name&dateOf=$date_transaction&amount=$amount\" target=\"_blank\" >$v</a></td>";
									break;
								
								default:
								echo "<td>$v</td>";	
								break;
							}
							
							break;
						
						default:
							echo "<td>$v</td>";
				
				
					}
				
				}
			echo " </tr>";
			} 
		 
			echo "</table>";
		
			
		}
		
		public function returnHtmlResponseWithdraw($response){
			//id, first_name, last_name, date_transaction, amount, notes, status
			echo "<table class=\"table-sm table-hover table-bordered table-striped\">";
			echo "<tr> ";
			echo "<td class=\"bg-success text-white\">First Name</td>";
			echo "<td class=\"bg-success text-white\">Last Name</td>";
			echo "<td class=\"bg-success text-white\">Date Of Transaction</td>";
			echo "<td class=\"bg-success text-white\">Amount</td>";
			echo "<td class=\"bg-success text-white\">Notes</td>";
			echo "<td class=\"bg-success text-white\">Status</td>";
			echo " </tr>";
			
			foreach ( $response as $row ) {
			
			$id = $row->id;
			$first_name = $row->first_name;
			$last_name = $row->last_name;
			$date_transaction = $row->date_transaction;
			$amount = $row->amount;
			// = $row;
			
			echo "<tr> ";
				foreach ($row as $k => $v){
					
					switch ($k){
						case "id":
							break;
						case "status":
							switch ($v){
								case "Pending":
									echo "<td><a href=\"https://form.jotform.me/91284522058457?transactionId=$id&firstName=$first_name&lastName=$last_name&dateOf=$date_transaction&amount=$amount\" target=\"_blank\" >$v</a></td>";
									break;
								
								default:
								echo "<td>$v</td>";	
								break;
							}
							
							break;
						
						default:
							echo "<td>$v</td>";
				
				
					}
				
				}
			echo " </tr>";
			} 
		 
			echo "</table>";
		
			
		}
		
		public function returnHtmlResponseAlt($response){
			
			$current_balance = 0;
			$current_code = "";
			$current_amount = 0;
			
			//var_dump($response);
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
		
		    
		
			foreach ( $response as $row ) {
			echo "<tr> ";
				foreach ($row as $k => $v){
					
					switch ($k){
						
						case "transaction_type_id":
							echo $this->generateTransactionCode($v);
							$current_code = $v;
							break;
						
						case "amount":
							$current_amount = $v;
							echo "<td>$v</td>";
							break;
							
						case "running_balance":
							
							if ($current_balance == NULL){
								$current_balance = 0;
								$current_balance = $current_amount;
								
								echo "<td>$current_balance</td>";
								
							} else {
								//$current_code = $row["transaction_type_id"];
								//var_dump($current_code);
								switch ($current_code){
									
									case 1:
	 								case 2:
										$current_balance += $current_amount;
										break;
									case 3:
									case 4:
									case 5:
										$current_balance -= $current_amount;
										break;
									
								}
								
								echo "<td>$current_balance</td>";
							}
								//$current_balance = $k;
							
							
							
							//echo "<td>We do magic Here</td>";
							break;
						//case "requiredFields":
							
							
						default:
							echo "<td>$v</td>";
						
					}
					
					/*if ($k == "transaction_type_id"){
					    
					    echo $this->generateTransactionCode($v);
					    
					} else {
					    echo "<td>$v</td>";
					}*/
				    
				}
			echo " </tr>";
			} 
		 
			echo "</table>";
		
			
		}
		
		
	}

	$transactionsController = new transactionsController();

    
	if ($checked=="true" && $startDate!=NULL && $endDate!=NULL){
		
		$formattedStartDate = $transactionsController->generateStartDate($startDate);
		$formattedEndDate = $transactionsController->generateEndDate($endDate);
		
		
		switch ($action) {
		    
		    case "viewTransactions":
                $temp = $transactionsController->getTransactionsForUserWithDate($firstName,$lastName,	$formattedStartDate,$formattedEndDate);
               // echo "Case1a";
    		    break;
		    
		    case "viewDeposits":
                $temp = $transactionsController->getDepositsForAllWithDate($formattedStartDate,$formattedEndDate);
                //echo "Case1b";
    		    break;
    		
    		case "viewWithdrawals":
                $temp = $transactionsController->getWithdrawalsForAllWithDate($formattedStartDate,$formattedEndDate);
                //echo "Case1c";
    		    break;    
		
		}
		
		//$temp = $transactionsController->getTransactionsForUserWithDate($firstName,$lastName,	$formattedStartDate,$formattedEndDate);
		
		
		
		//$transactionsController->returnHtmlResponse($temp);
	    
	    //echo "Case1";
	
	} else {
		
		
		switch ($action) {
		    
		    case "viewTransactions":
                $temp = $transactionsController->getTransactionsForUser($firstName,$lastName);
                //echo "Case2a";
    		    break;
		    
		    case "viewDeposits":
                $temp = $transactionsController->getDepositsForAll();
                //echo "Case2b";
    		    break;
    		
    		case "viewWithdrawals":
                $temp = $transactionsController->getWithdrawalsForAll();
                //echo "Case2c";
    		    break;    
		
		}
		
		//$temp = $transactionsController->getTransactionsForUser($firstName,$lastName);
		
	
		//echo "Case2";
	}
	
	
	switch ($action) {
		
		case "viewWithdrawals":
		$transactionsController->returnHtmlResponseWithdraw($temp);	
			break;
		case "viewDeposits":
		$transactionsController->returnHtmlResponseDeposit($temp);	
			break;
		default:
		$transactionsController->returnHtmlResponse($temp);	
	
	}
	
	//var_dump($temp);
	
?>