<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html class="supernova"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta property="og:title" content="SEDPI Social Investments Online" >
 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=1" />
<meta name="HandheldFriendly" content="true" />
<title>SEDPI Social Investments Online Agreement</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />
 
 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
 

 
<link rel="stylesheet" href="css/style.css" >
<link href="{{ asset('css/app.css') }}" rel="stylesheet"> 


 
<style type="text/css" id="form-designer-style">
     

.whitebg {
    background: white !important;
}
.show {
     opacity: 1;
    
}
.modal-open {
  /*
  background-color: black;
  opacity: 0.1;
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: -1 !important;
  */
}

.mopen {
  
  background-color: black;
  opacity: 0.1;
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: -1 !important;
  
}

.mheight {
    height: 120px;
}

.greenbg {
    background: #1c4220;
}

.redbdr {
    border: 1px solid red;
}


.bluebdr {
    border: 1px solid blue;
}


</style>


 
 
</head>
<body class="greenbg" >
  
  
  <div role="main" class="container whitebg form_all p-5 ml-auto mr-auto" >
     <div class="container-fluid greenbg pt-2 pb-2 pl-xs-1 pr-xs-1 rounded"> 
        <div class="row no-gutters">
            <div class="col-6-md ml-auto mr-auto">
                <img class="img-fluid  mheight rounded my-3" src="https://www.vincerapisura.com/sri/storage/sedpi_logo_1.gif"    >
            </div>
        </div> <!-- end row -->
     </div> <!-- end container 1 -->
     <div class="container-fluid pt-2 pb-2 pl-xs-1 pr-xs-1 rounded mt-5 mb-5"> 
        <div class="row no-gutters mt-5 mb-5">
            
            <div class="col-6-md ml-auto mr-auto">
                <form action="{{ route("agreement.set") }} "method="post">
                {{ csrf_field() }}
                <div class="card my-3  border border-success">
						    
					<div class="card-body text-center">
					    <p>By clicking "I agree" you agree to the terms and conditions of the joint venture that can be found here: </p>
					    <a class="" href="http://bit.ly/sedpijva">http://bit.ly/sedpijva</a>
					</div>
					<div class="card-footer ">
    					<div class="form-group text-center">
        					<button type="submit" class="btn btn-success btn-lg " data-dismiss="modal" >I Agree</button>
    					</div>
    				</div>
				</div>
				
				  <input type="hidden" name="user_id" class="form-control" id="user_id"  value="{{ Auth::User()->id }}" >
				</form>
            </div>
        </div> <!-- end row -->
     </div> <!-- end container 1 -->
 </div> <!-- end main -->
  
      

 
 
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
//$.noConflict();
</script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
 

 
<script>
        
      
    
</script>

</body>
</html>
 
