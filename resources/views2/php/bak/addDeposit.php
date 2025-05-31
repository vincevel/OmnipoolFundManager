<?php
	session_start();
	include 'transaction.php';

	include 'data.php';
	include 'transactionData.php';
	
    /*
    $firstName = $_POST["q70_name70"]["first"]; 
    $lastName = $_POST["q70_name70"]["last"];
    $email=$_POST["q71_email71"];
    $date = $_POST["q41_whenDid"]["year"] . "-" . $_POST["q41_whenDid"]["month"] . "-" . $_POST["q41_whenDid"]["day"];
    $amount = $_POST["q40_howMuch40"]; 
    $notes = $_POST["q143_instructionsTo143"];
    $file_name = $_POST["temp_upload"]["q42_uploadA"][0];
    */
	
	/*
	//INPUTS
    $inputs = array(); 
	$inputs["first_name"] = "Diane"; 
    $inputs["last_name"] = "Lumbao";
    $inputs["email"]="test@yahoo.com";
    $inputs["date_transaction"] = "2019-05-16";
	//ADDFUNCTION TO CONSTRUCT DATE
	
    $inputs["amount"] = "12314"; 
    $inputs["notes"] = "testInstructs";
    $inputs["file_name"] = "black.png";
	*/
	
	var_dump($_POST);
	
	if ($_POST["ifyou"]=="Advice SEDPI of my initial investment"){
		$inputs["first_name"] = $_POST['name70']['0']; 
		$inputs["last_name"] = $_POST['name70']['1'];
		$inputs["email"]=$_POST["email71"];
		$inputs["date_transaction"] = $_POST['whendid']['2'] . "-" . $_POST['whendid']['0'] . "-" . $_POST['whendid']['1'];
		$inputs["amount"]  = $_POST["howmuch40"]; 
		$inputs["notes"] = $_POST["whatis"];
		$inputs["file_name"] = $_POST['uploada']['0'];
	} else if($_POST["ifyou"]=="deposit2") {
		/*$inputs["first_name"] = $_POST["q72_name72"]["first"];
		$inputs["last_name"] = $_POST["q72_name72"]["last"]; 
		$inputs["email"] = $_POST["q73_email73"];
		$inputs["date_transaction"] = $_POST["q48_whenDid48"]["year"] . "-" . $_POST["q48_whenDid48"]["month"] . "-" . $_POST["q48_whenDid48"]["day"];
		$inputs["amount"] = $_POST["q49_howMuch49"]; 
		$inputs["notes"] = $_POST["q142_instructionsTo"] . $_POST["q51_whyAre51"];
		$inputs["file_name"] = $_POST["temp_upload"]["q50_uploadA50"][0];*/
	}
	
	
	class addDepositsController {
	
		public function __construct(){}
	
		public function addDeposit($inputs){
			 $transactionData = new TransactionData("transactions");
		 	 $transaction = new Transaction($inputs);
			 var_dump($transaction);
			 
			 
			 //ADDITIONAL DATA
			 $transactionData->getRunningTotalForDeposit($transaction);
			 $rowNum = $transactionData->checkForLaterTransactions($transaction);
			 //var_dump($rowNum);
			 $transaction->setAdditionalData();
			 
			   //QUERY Preparation	
			 $transactionQueryObj = $transaction->buildInsertSql();
		     var_dump($transactionQueryObj);
		     //var_dump($transaction->checkRequiredFields());
			 
			 //ACTUAL INSERT
	      	 
	      	 //if ($transaction->checkRequiredFields()){
	      	 $transactionData->insertDeposit($transactionQueryObj);
	      	 
			 
			 
			 //}
			 
			 //ADDITIONAL UPDATE
			 if ($rowNum > 0){
				 
				$updateTransactionQueryObj = $transaction->buildUpdateSql($transaction);
				$transactionData->updateLaterTransactionsForDeposits($updateTransactionQueryObj); 
			 }
			 
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
	
           
		}
		
		
		
	}

	$addDepositsController = new addDepositsController();
	//CONSTRUCT DATE BEFORE INSERTING
	
	$addDepositsController->addDeposit($inputs);
	
?>