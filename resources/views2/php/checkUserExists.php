<?php
	

	include 'user.php';

	include 'data.php';
	include 'userData.php';
	
	//var_dump($_POST);  
	
	//INPUTS
	$userName = trim($_POST['userName']);
     
	/*$userName = trim("dianelumbao");
    $password = trim("test123");*/

	class loginController 
	{
		public function __construct(){}
	
		public function checkUserInDb($username,$password){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$userData = new UserData("users");
			return $userData->getLoginDataForUser($username,$password);					
		}
		
		public function checkUserNameInDb($username){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$userData = new UserData("users");
			return $userData->checkUserNameInDb($username);					
		}
		
		public function returnResponse($response){
		
			foreach ($response as $item){
    			echo json_encode($item);
			}
			return $response;
		}
		
	}

	$loginController = new loginController();

    $returnItems = $loginController->checkUserNameInDb($userName);
    $loginController->returnResponse($returnItems);

?>