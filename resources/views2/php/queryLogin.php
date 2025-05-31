<?php session_start(); ?> 

<?php
 

	include 'user.php';

	include 'data.php';
	include 'userData.php';
	
	//var_dump($_SERVER['HTTP_ORIGIN']);
	
	//var_dump($_POST);  
	
	//INPUTS
	$userName = trim($_POST['userName']);
    $accesscode = trim($_POST['accesscode']);
	/*$userName = trim("dianelumbao");
    $password = trim("test123");*/

	class loginController 
	{
		public function __construct(){}
	
		public function checkUserInDb($username,$accesscode){
			//QUERY DB IF USERNAME AND PASSWORD EXISTS
			$userData = new UserData("users");
			$temp =  $userData->getLoginDataForUser($username,$accesscode);	
			$userData->dbClose();
			return $temp;
		}
		
		public function returnResponse($response){
		    $result = array();
			foreach ($response as $row){
    			echo json_encode($row);
			    
			    /*foreach ($row as $k => $v){
                    switch ($k){
                        default:
                        echo $v;
                    }
			           
			    }*/
			    
			}
			//echo implode(",",$result);
			return $response;
		}
		
	}

	$loginController = new loginController();

    $returnItems = $loginController->checkUserInDb($userName,$accesscode);
    $loginController->returnResponse($returnItems);

?>