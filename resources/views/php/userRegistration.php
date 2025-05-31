<?php
	//session_start();
	//include 'transaction.php';
	include 'user.php';

	include 'data.php';
	include 'userData.php';
	
  
	//var_dump($_POST);
	
	if ($_POST["actionString"]=="register1"){
		//$inputs["first_name"] = $_POST["q70_name70"]["first"]; 
		
		//$inputs["full_name"] =  "";
		$inputs["user_name"] = strtolower($_POST["q167_custom1167"]);
		$inputs["first_name"] = $_POST["q3_fullName3"]["first"];
		$inputs["middle_name"] = $_POST["q3_fullName3"]["middle"];
		$inputs["last_name"] = $_POST["q3_fullName3"]["last"];
		
		$inputs["phone_no"] = $_POST["q6_phoneNumber6"]["area"] . "-" .$_POST["q6_phoneNumber6"]["phone"];
		$inputs["user_pass"] = $_POST["q168_custom2168"];
		//$inputs["password2"] = $_POST["pq14_country2"];
		$inputs["user_email"] = $_POST["q4_email4"];
		
		
		
		$inputs["country"] = $_POST["q14_country"];
		
		
		$inputs["address_line1"] = $_POST["q129_address"]["addr_line1"];
		$inputs["address_line2"] = $_POST["q129_address"]["addr_line2"];
		$inputs["city"] = $_POST["q129_address"]["city"];
		$inputs["state_province"] = $_POST["q129_address"]["state"];
		$inputs["postal_zip_code"] = $_POST["q129_address"]["postal"];
		
		
		$inputs["beneficiary1_first_name"] = $_POST["q27_beneficiary1"]["first"];
		$inputs["beneficiary1_middle_name"] = $_POST["q27_beneficiary1"]["middle"];
		$inputs["beneficiary1_last_name"] = $_POST["q27_beneficiary1"]["last"];
		$inputs["beneficiary1_relationship"] = $_POST["q28_relationship1"];
		
		$inputs["beneficiary2_first_name"] = $_POST["q29_beneficiary2"]["first"];
		$inputs["beneficiary2_middle_name"] = $_POST["q29_beneficiary2"]["middle"];
		$inputs["beneficiary2_last_name"] = $_POST["q29_beneficiary2"]["last"];
		$inputs["beneficiary2_relationship"] = $_POST["q30_relationship2"];
		
		$inputs["beneficiary3_first_name"] = $_POST["q31_beneficiary3"]["first"];
		$inputs["beneficiary3_middle_name"] = $_POST["q31_beneficiary3"]["middle"];
		$inputs["beneficiary3_last_name"] = $_POST["q31_beneficiary3"]["last"];
		$inputs["beneficiary3_relationship"] = $_POST["q32_relationship3"];
		
		$inputs["name_id_first_name"] = $_POST["q121_nameAs"]["first"];
		$inputs["name_id_middle_name"] = $_POST["q121_nameAs"]["middle"];
		$inputs["name_id_last_name"] = $_POST["q121_nameAs"]["last"];
		$inputs["name_id_suffix"] = $_POST["q121_nameAs"]["suffix"];
		
		
		$inputs["kind_id"] = $_POST["q122_kindOf"];
		$inputs["id_number"] = $_POST["q125_idNumber"];
		$inputs["date_issue"] = $_POST["q123_dateOf"]["year"] ."-". $_POST["q123_dateOf"]["month"] ."-" . $_POST["q123_dateOf"]["day"];
		
		$inputs["place_issue"] = $_POST["q124_placeOf"];
		
		$inputs["govt_id_pic"] = $_POST["temp_upload"]["q126_uploadPicture"][0];
		
		$inputs["account_id"] = md5(uniqid());
		
	}
	
	
	class userRegistrationController {
	
		public function __construct(){}
	
		public function registerUser($inputs){
		
			 $userData = new UserData("users");
			 $user = new User($inputs);
			 //var_dump($user);
			 
			 //ADDITIONAL DATA
			 
			 //BUILD SQL FROM USER
			 $userQueryObj = $user->buildInsertSql();
			 
			 var_dump($userQueryObj);
			 
			 
			 //var_dump($user->checkRequiredFields());
			 //CHECKREQUIRED BEFORE INSERT
			 if ($user->checkRequiredFields()){
	      	    $userData->insertNewUser($userQueryObj);
	      	 
			 
			 
			 }
		}
				
	}

	$userRegistrationController = new userRegistrationController();
	//CONSTRUCT DATE BEFORE INSERTING
    
	$userRegistrationController->registerUser($inputs);	
	 
	
?>