<?php

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
	
	class addWithdrawController {
	
		public function __construct(){}
	
		public function addWithdraw($inputs){
			 $transactionData = new TransactionData("transactions");
		 	 $transaction = new Transaction($inputs);
			 
			 //ADDITIONAL DATA
			 $transactionData->getRunningTotalForWithdraw($transaction);
			 //maybe pull out user id and client id?
			 
			 //var_dump($temp);
	
             //QUERY Preparation	
			 $transactionQueryObj = $transaction->buildInsertSql();
		     var_dump($transaction->checkRequiredFields());
			 
			 //ACTUAL INSERT
	      	 $transactionData->insertWithdraw($transactionQueryObj);
	
		}
		
		
		
	}

	$addWithdrawController = new addWithdrawController();
	//CONSTRUCT DATE BEFORE INSERTING
	
	$addWithdrawController->addWithdraw($inputs);
	
?>