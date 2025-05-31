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
	
	//var_dump($_POST);
	
	if ($_POST["actionString"]=="Withdraw243535"){
		 
	} else if($_POST["actionString"]=="withdraw1") {
		$inputs["first_name"] = $_POST["q74_name74"]["first"];
		$inputs["last_name"] = $_POST["q74_name74"]["last"]; 
		$inputs["email"] = $_POST["q75_email75"];
			
		$inputs["date_transaction"] = $_POST["q55_dateRequest"]["year"] . "-" . $_POST["q55_dateRequest"]["month"] . "-" . $_POST["q55_dateRequest"]["day"];
		   
		$inputs["amount"] = $_POST["q56_howMuch56"]; 
			
		$inputs["notes"] = $_POST["q142_instructionsTo"];
		$inputs["notes_withdraw_reason"] = $_POST["q57_whyAre57"];
			
		$inputs["file_name"]  = $_POST["temp_upload"]["q84_governmentIssued"][0];
			
		$inputs["bank_name"] = $_POST["q77_bankName"];
		$inputs["bank_acct_no"] = $_POST["q82_accountNumber"];
		$inputs["bank_acct_name"] = $_POST["q78_bankAccount"];
		$inputs["bank_branch"] = $_POST["q79_bankBranch"];
		$inputs["bank_account_type"] =  $_POST["q81_bankAccount81"];
		$inputs["bankrouting_no"] = $_POST["q83_bankroutingNumber"];
		//AUTHORIZATION LETTER
		
	}
	
	
	class addWithdrawController {
	
		public function __construct(){}
	
		public function addWithdraw($inputs){
			 $transactionData = new TransactionData("transactions");
		 	 $transaction = new Transaction($inputs);
			 //var_dump($transaction);
			 
			 
			 //ADDITIONAL DATA
			 $transactionData->getRunningTotalForWithdraw($transaction);
			 $rowNum = $transactionData->checkForLaterTransactions($transaction);
			 //var_dump($rowNum);
			 $transaction->setAdditionalDataWithdraw();
			 
			 //QUERY Preparation	
			 $transactionQueryObj = $transaction->buildInsertSql();
		     var_dump($transactionQueryObj);
		     //var_dump($transaction->checkRequiredFields());
			 
		 
			 
			 //ACTUAL INSERT
			 $fields = array("first_name","last_name","date_transaction","amount","file_name","bank_name","bank_acct_no","bank_acct_name","bank_branch","bank_account_type","bankrouting_no");
	      	 $transaction->setRequiredFields($fields);
	      	 if ($transaction->checkRequiredFields()){
	      	     $transactionData->insertWithdraw($transactionQueryObj);
	      	 
			 
			 
			 }
			 
			 //ADDITIONAL UPDATE
			 if ($rowNum > 0){
				 
				 $updateTransactionQueryObj = $transaction->buildUpdateSqlWithdraw($transaction);
				 $transactionData->updateLaterTransactionsForWithdraw($updateTransactionQueryObj); 
			 }
			 
			  
			    
			 //var_dump($transaction);
	
           
		}
		
		
		
	}

	$addWithdrawController = new addWithdrawController();
	//CONSTRUCT DATE BEFORE INSERTING
	
	$addWithdrawController->addWithdraw($inputs);
	
?>