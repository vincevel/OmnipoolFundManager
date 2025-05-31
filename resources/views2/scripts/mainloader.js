        
        $firstNameT1 = jQuery("#first_188");
        $lastNameT1 = jQuery("#last_188");
        $transactionDisplayT1 = jQuery("#header_196");
        
        
        jQuery( document ).ready(function() {
          
          
            
          
            //console.log("loaded");
            input = { 
                firstName: $firstNameT1.val(), 
                lastName: $lastNameT1.val(), 
                action: "viewTransactions",
                checked: false
            }
            
            jQuery.post( "../php/queryTransactions.php", input, function( result ) {
                    $transactionDisplayT1.html(result);
            });
             
        });    
    