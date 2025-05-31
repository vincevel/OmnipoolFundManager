<?php session_start(); ?>

<?php 
	 
	
	
	//include 'transaction.php';
	include 'user.php';

	include 'data.php';
	include 'userData.php';
	
  
	 //var_dump($_POST);
	
	
	class userSessionController {
	
		public function __construct(){}
	
		public function getData(){
		
			 return $_SESSION;
 
		}
		
		public function returnResponse($response){
		
			foreach ($response as $item){
    			echo json_encode($item);
			}
			return $response;
		}
		
		public function returnResponseSession($response){
		
			 
    			echo json_encode($response);
			
		}
			
	}

	$userSessionController = new userSessionController();
	//CONSTRUCT DATE BEFORE INSERTING
    
	$returnItems = $userSessionController->getData();	
 
    //var_dump($returnItems);
    $userSessionController->returnResponseSession($returnItems);
	
?>