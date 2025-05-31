<?php
	session_start();
	include 'transaction.php';

	include 'data.php';
	include 'transactionData.php';
	
	$inputs["firstName"] = $_POST["q72_name72"]["first"];
    $inputs["lastName"] = $_POST["q72_name72"]["last"]; 
    $inputs["email"] = $_POST["q73_email73"];
    $inputs["date"] = $_POST["q48_whenDid48"]["year"] . "-" . $_POST["q41_whenDid"]["month"] . "-" . $_POST["q41_whenDid"]["day"];
    $inputs["amount"] = $_POST["q49_howMuch49"]; 
    $inputs["notes"] = $_POST["q142_instructionsTo"] . $_POST["q51_whyAre51"];
    $inputs["file_name"] = $_POST["temp_upload"]["q50_uploadA50"][0];
	
	
	class addDepositsController {
	
		public function __construct(){}
	
		public function addDeposit($inputs){
			 $transactionData = new TransactionData("transactions");
		 	 $transaction = new Transaction($inputs);
			 
			 //ADDITIONAL DATA
			 $transactionData->getRunningTotalForDeposit($transaction);
			 $transaction->setAdditionalData();
			 //USER ID
			 //ACCOUNT_ID
			 //TRANSACTION TYPE ID= 1
			 //maybe pull out user id and client id?
			 //IS POSTED = 1
			 //NOTES = REMARKS
			 //3 x TIME STAMPS
			 
			 //STATUS
			 //REQUESTED BY
			    
			 //CAN BE NULL
			 //TRANSACTION ID
			 //3 x BANK
			 //ACCOUNT_NAME
			    
			 //var_dump($transaction);
	
             //QUERY Preparation	
			 $transactionQueryObj = $transaction->buildInsertSql();
		     var_dump($transactionQueryObj);
		     //var_dump($transaction->checkRequiredFields());
			 
			 //ACTUAL INSERT
	      	 
	      	 if ($transaction->checkRequiredFields()){
	      	  $transactionData->insertDeposit($transactionQueryObj);
	      	 }
		}
		
		
		
	}

	$addDepositsController = new addDepositsController();
	//CONSTRUCT DATE BEFORE INSERTING
	
	$addDepositsController->addDeposit($inputs);
	
?>