
$username = jQuery("#label_165");
$accessCode = jQuery("#label_166");

$usernameR = jQuery("#label_167");
$accessCode1R = jQuery("#label_168");
$accessCode2R = jQuery("#label_169");
$userNameSublabel = jQuery("#sublabel_input_167");

jQuery(function() {
    $username.text("Username");
	$accessCode.text("Access Code");
	$usernameR.text("Username");
	$accessCode1R.text("Access Code");
	$accessCode2R.text("Repeat Access Code");
	$userNameSublabel.text("");
	//console.log( "ready!" );
});console.log("Hello there")

var $firstNameHolder;
var $firstName;
var $placeOfIssue;

$firstName = jQuery("#first_3");
$lastName = jQuery("#last_3");
$code = jQuery("#input_161");
$link = jQuery("#input_160");

$codeValue = "Code: sedpi 2004";
$linkValue = "<a href=" + "https://www.vincerapisura.com" + ">www.vincerapisura.com</a>";

var data2;

$nextPage = jQuery("#form-pagebreak-next_35");
 
$nextPage.click(function() {
    data2 = { 
        firstName: $firstName.val(), 
        lastName: $lastName.val() 
    }
    
//console.log("Hello there query");
    jQuery.post( "../php/query.php", data2, function( data ) {
         
        item = data[data.length-1];
        // data = data + 0;
        //console.log( typeof(item) );
         //console.log(":" + item + ":" );
        num = parseInt(item, 10)
          //console.log(  num );
           //console.log(  typeof(num) );
        if (num == 1){
            $code.val($codeValue);
            $link.val($linkValue);
            
            
            
          //console.log("Match")
          
        }
 
     });

});

  
  
console.log("Hello there transactions")

 



$queryBtnT = jQuery("#input_176");
$firstNameT = jQuery("#first_172");
$lastNameT = jQuery("#last_172");
$startDateT = jQuery("#lite_mode_174");
$endDateT = jQuery("#lite_mode_175");
$checkBoxT = jQuery("#input_173_0");
$transactionDisplay = jQuery("#header_177");



$queryBtnT.click(function(event) {
    
	event.preventDefault()
    $formAll.css( "width", 750);
   // var isChecked = $checkBoxT.val();
    
    //console.log(checked);
    if ($checkBoxT.prop("checked")) {
         data2 = { 
        firstName: $firstNameT.val(), 
        lastName: $lastNameT.val(), 
        startDate: $startDateT.val(),
        endDate: $endDateT.val(),
        action: "viewTransactions",
        checked: $checkBoxT.prop("checked")
          }
        
        
    }else {
        
         data2 = { 
        firstName: $firstNameT.val(), 
        lastName: $lastNameT.val(), 
        action: "viewTransactions",
        checked: $checkBoxT.prop("checked")
          }
    
    }


   
    
//console.log("Hello there query");
    jQuery.post( "../php/queryTransactions.php", data2, function( data ) {
         
         console.log(data);
  
        $transactionDisplay.html(data);
 
 
     });

});

  
  
console.log("Hello there deposits")


$queryBtnD = jQuery("#input_181");
 
 
$startDateD = jQuery("#lite_mode_174");
$endDateD = jQuery("#lite_mode_175");
$checkBoxD = jQuery("#input_173_0");
$transactionDisplayD = jQuery("#header_177");
 



$formAll = jQuery(".form-all");
 
$queryBtnD.click(function() {


$formAll.css( "width", 850);

 
    if ($checkBoxD.prop("checked")) {
         data2 = { 

           startDate: $startDateD.val(),
           endDate: $endDateD.val(),
           action: "viewDeposits",
           checked: $checkBoxD.prop("checked")
          }
        
        
    }else {
        
         data2 = { 
            
            action: "viewDeposits",
            checked: $checkBoxD.prop("checked")
            //dummy: "test"
 
         }
    
    }
    
    jQuery.post( "../php/queryTransactions.php", data2, function( data ) {
         
        console.log(data);
        $transactionDisplayD.html(data);
 
 
     });

});

  
  
console.log("Hello there withds")

 

$queryBtnW = jQuery("#input_182");
 
 
$startDateW = jQuery("#lite_mode_174");
$endDateW = jQuery("#lite_mode_175");
$checkBoxW = jQuery("#input_173_0");
$transactionDisplayW = jQuery("#header_177");

 

$formAll = jQuery(".form-all");

 
$queryBtnW.click(function() {
 
    $formAll.css( "width", 850);
 
    if ($checkBoxW.prop("checked")) {
         data2 = { 

           startDate: $startDateW.val(),
           endDate: $endDateW.val(),
           action: "viewWithdrawals",
           checked: $checkBoxW.prop("checked")
          }
        
        
    }else {
        
         data2 = { 
            
            action: "viewWithdrawals",
            checked: $checkBoxD.prop("checked")
            //dummy: "test"
 
         }
    
    }
    
    jQuery.post( "../php/queryTransactions.php", data2, function( data ) {
         
        console.log(data);
        $transactionDisplayW.html(data);
 
 
     });

});

  
  
$printerBtn1 = jQuery("#input_print_176");
$printerBtn2 = jQuery("#input_print_181");
$printerBtn3 = jQuery("#input_print_182");

$printerBtn1.click(function(event) { printContent('header_177') });
$printerBtn2.click(function(event) { printContent('header_177') });
$printerBtn3.click(function(event) { printContent('header_177') }); 
 
 function printContent(el){

    $body = jQuery("body");
    $top = jQuery(".supernova");
   
    var h = document.getElementById(el).innerHTML;
   
    var d = jQuery("<div>").addClass("print").html(h).appendTo("html");
   
    
    $body.hide();
    $top.css('background-color','white');

    window.print();
    d.remove();
    
    $top.css('background-color','#1c4220');
    $body.show();
 
  }//REGISTER ELEMENTS

$userName = jQuery("#input_165");
$accesscode2 = jQuery("#input_166");
$loginNextBtn = jQuery("#form-pagebreak-next_91");
$loginIndicator = jQuery("#input_162");
$socialInvestmentDropDown = jQuery("#input_93");


$accesscode2.keyup(function(event) { 
	//CALCULATE before clicking
	console.log("Focus Out");
	
	message = $socialInvestmentDropDown.val();
	switch(message){
    
        case "Existing SEDPI social investor":
		case "SEDPI admin":
		   
		data2 = { 
			userName: $userName.val(), 
			accesscode: $accesscode2.val(), 
			action: "queryLogin"
    	}
	 
    	jQuery.post( "../php/queryLogin.php", data2, function( dataInput ) {
			 //console.log(dataInput) 
			
			
			data = jQuery.parseJSON(dataInput) 
			//console.log(data.rows)
			//$loginIndicator.val("1");
			
			
			if (data.rows == 1){
			    $loginIndicator.val("1");
			}  else {
				$loginIndicator.val("1");
			}
	        
		 
		
		});
		   break;
		     
		default:
			 break;
    }    
	
	
	
});


$loginNextBtn.click(function(event) { 
	 
	console.log("login button2 clicked");
	 
	
});



//REGISTER ELEMENTS

 

$userNameField = jQuery("#input_167");
$nextBtn1 = jQuery("#form-pagebreak-next_35");

$password1 = jQuery("#input_168");
$password2 = jQuery("#input_169");
//$hiddenUserNameField = jQuery("#custom_input_15");
$orig = $nextBtn1.css("background");
function checkUserExists(){
	
	 inputData = { 
            
            userName: $userNameField.val()
    
     }
	
	
    //var str = $userNameField.val();
    return jQuery.ajax({
        url: "../php/checkUserExists.php",
        method: "POST",
        data: inputData,
        async: true
    });
    
}



$userNameField.keyup(function(event){
	//console.log($userNameField.val())
	jQuery.when(checkUserExists()).then(function success(inputData){
         
		 
		 //data = jQuery.parseJSON(data5) 
		 console.log(inputData)
		 data = jQuery.parseJSON(inputData) 
		 
		 $usernameSublabel = jQuery("#custom_sublabel_input_14");
    	 
		 //console.log($orig);
		 
		 if (data.rows == 1){
		 	
			$usernameSublabel.text("USERNAME ALREADY EXISTS");
			$usernameSublabel.css("color","red");
 
			$nextBtn1.prop('disabled', true);
			$nextBtn1.css("background", "red");
			
			
		 } else {
			$usernameSublabel.text("Username"); 
 
			$usernameSublabel.css("color","#6f6f6f");
			$nextBtn1.prop('disabled', false);
			$nextBtn1.css("background", $orig);
 
		 }
	
	})
	
});





$password2.keyup(function(event){
	
	$password2Sublabel = jQuery("#custom_sublabel_input_16");
	if ($password1.val() != $password2.val()){
		$password2Sublabel.text("PASSWORDS DOES NOT MATCH");
		$password2Sublabel.css("color","red");
		$nextBtn1.prop('disabled', true);
		$nextBtn1.css("background", "red");
			
	} else {
		$password2Sublabel.text("Repeat AccessCode"); 
		$password2Sublabel.css("color","#6f6f6f");
		$nextBtn1.prop('disabled', false);
		$nextBtn1.css("background", $orig);
		
		
	}
	
});	

$password1.keyup(function(event){
	$password2Sublabel = jQuery("#custom_sublabel_input_16");
	//if ($password2.val()!= NULL){
	
		if ($password1.val() != $password2.val() && $password2.val()!="" ){
			$password2Sublabel.text("PASSWORDS DOES NOT MATCH");
			$password2Sublabel.css("color","red");
			$nextBtn1.prop('disabled', true);
			$nextBtn1.css("background", "red");
				
		} else {
			$password2Sublabel.text("Repeat AccessCode"); 
			$password2Sublabel.css("color","#6f6f6f");
			$nextBtn1.prop('disabled', false);
			$nextBtn1.css("background", $orig);
			
		}
	//}
});	
//REGISTER ELEMENTS


$userRegisterBtn = jQuery("#input_128");

function registration(){
    var str = $wholeForm.serialize() + '&actionString=register1';
    return jQuery.ajax({
        url: "../php/userRegistration.php",
        method: "POST",
        data: str,
        async: false
    });
    
}


$userRegisterBtn.click(function(event){
	
	//event.preventDefault();
    jQuery.when(registration()).then(function success(data5){
         console.log(data5)
    })
	
});


$wholeForm = jQuery(".jotform-form")

//DEPOSIT
$btn = jQuery("#input_45");


//ADDTL DEP
$btn2 = jQuery("#input_52");

//WITHDRAWAL
$btn3 = jQuery("#input_58");


function ajax1(){
    var str = $wholeForm.serialize() + '&actionString=deposit1';
    return jQuery.ajax({
        url: "../php/addDeposit.php",
        method: "POST",
        data: str,
        async: false
    });
    
}

function ajax2(){
    var str = $wholeForm.serialize() + '&actionString=deposit2';
    
	//console.log(str);
    return jQuery.ajax({
        url: "../php/addDeposit.php",
        method: "POST",
        data: str,
        async: false
    });
    
}

function ajax3(){
    var str = $wholeForm.serialize() + '&actionString=withdraw1';
    return jQuery.ajax({
        url: "../php/addWithdraw.php",
        method: "POST",
        data: str,
        async: false
    });
    
}

$btn.click(function(e) {
      //e.preventDefault();
    console.log("clicked");
    jQuery.when(ajax1()).then(function success(data5){
        console.log(data5)
    })
    
});


$btn2.click(function(e) {
    //e.preventDefault();
     jQuery.when(ajax2()).then(function success(data5){
         console.log(data5)
    })

});
  
$btn3.click(function(e) {
    //e.preventDefault();
    jQuery.when(ajax3()).then(function success(data5){
         console.log(data5)
    })
  
 
});console.log("Hello there transactions")

$viewTransactionNextBtn = jQuery("#form-pagebreak-next_67");

$viewTransactionBackBtn = jQuery("#form-pagebreak-back_37");
$adminNextBtn = jQuery("#form-pagebreak-next_95");

 
$firstName = jQuery("#first_172");
$lastName = jQuery("#last_172");

$firstNameInitialDep = jQuery("#first_70");
$lastNameInitialDep = jQuery("#last_70");
$accountIdInitialDep = jQuery("#input_184");
 

$firstNameAddtlDep = jQuery("#first_72");
$lastNameAddtlDep = jQuery("#last_72");
$accountIdAddtlDep = jQuery("#input_186");


$firstNameWith = jQuery("#first_74");
$lastNameWith = jQuery("#last_74");
$accountIdWith = jQuery("#input_185");


$investorDropDown = jQuery("#input_38");

function pullSessionData(){

	data2 = { 
			
			action: "getSessionData"
    }
 
    jQuery.post( "../php/userSession.php", data2, function( dataInput ) {
         

            data = jQuery.parseJSON(dataInput) 
		    console.log(data) 
	
			$firstName.val(data.first_name);
 			$lastName.val(data.last_name);
			 
			
			$firstNameInitialDep.val(data.first_name);
			$lastNameInitialDep.val(data.last_name);
			$accountIdInitialDep.val(data.account_id);

			$firstNameAddtlDep.val(data.first_name);
			$lastNameAddtlDep.val(data.last_name);
			$accountIdAddtlDep.val(data.account_id);

			$firstNameWith.val(data.first_name);
			$lastNameWith.val(data.last_name); 
			$accountIdWith.val(data.account_id);
     });
	
}

$adminNextBtn.click(function(event) {
	console.log("request for session data");
    pullSessionData();  
	
});

 
$viewTransactionNextBtn.click(function(event) {
    
    console.log("request for session data");
    pullSessionData();    
	

});

$viewBackBtn = jQuery("#form-pagebreak-back_91");
$viewBackBtn.click(function(event) {
    
  $transactionDisplay.html("");
	

});  
  
  
