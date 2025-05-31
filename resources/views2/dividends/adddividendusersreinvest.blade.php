<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reinvest</title>
 <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>

	 #search {
	  
	 }
 	
	
</style>
</head>
<body   id="home">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
	<!-- form section -->
  	<section id="search" class="pb-5  " >

	  	<div class="container">
		
			<div class="row">
			    
				<div class="col-md-6  mt-5">
			 	    
						<div class="card my-3  border border-primary">
						    
							<div class="card-body">
							    <h3>Reinvest</h3>
								<form action="/sri/dividenduser/reinvest" method="post">
                                     {{ csrf_field() }}
									<div class="form-group">
									    <label for="id">Id</label>
									    <input type="text" name="id" class="form-control" id="id" placeholder="Id" value="{{ $user->id }}" >
				  					</div> <!-- end form group   --> 	

									<div class="form-group">
									    <label for="name">Name</label>
									    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $user->first_name . " " .  $user->last_name }}" >
				  					</div> <!-- end form group   --> 	


									 <div class="form-group">
									    <label for="amount">Reinvestment Amount</label>
									    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" >
				  					</div>
				  					
				  					
				  					<!--
				  					<div class="form-group">
									    <label for="amount">Contribution Amount</label>
									    <input type="text" class="form-control bg-success text-white" id="amount2" name="amount2" placeholder="Amount" >
				  					</div>
				  					-->
				  					
				  					<div class="form-group">
									    <label for="select1">Investment</label>
									        <select class="form-control" id="investment1" name="investment1">
                                              @foreach($investments as $type)
                                                <option>{{ $type->investment_type }}</option>
                                              @endforeach
                                            </select>
				  					</div>
				  					
				  					<!-- end form group   --> 	
				  					 <div class="form-group mb-4">
									    <label for="amount">Date</label>
									    <input type="text" class="form-control" id="date" name="date" value="01/01/2021" placeholder="Amount" >
				  					     <!-- end form group 01/01/2020 to  2020-01-01 --> 	
				  					</div> <!-- end form group   --> 	

									
	 									<input type="submit" value="Reinvest" class="btn btn-outline-primary btn-block">


								</form>
								 <a href="/sri/dividenduser" class="btn btn-success btn-block mt-4">Back</a>
							</div> <!-- end card-body  --> 	
						</div> <!-- end card   --> 	
				
				 
				</div>   <!-- end col   --> 		
            
            	
           
			</div>  <!-- end row   --> 		


	  	</div> <!-- end container   -->
	</section>


<!--   -->
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

     <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
	
	<script>
			//Get current year for copyright
			$('#year').text(new Date().getFullYear());

			//init scrolspy
		 
             $('#date').datepicker({
            uiLibrary: 'bootstrap4'
        });

	</script>
</body>
</html>