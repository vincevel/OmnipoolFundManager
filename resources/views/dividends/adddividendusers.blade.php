<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Dividend</title>
 <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
<style>

	 #search {
	  
	 }
 	.red { 
            color: red;
        }
        
         	.redheavy { 
            color: red;
            font-weight: bold;
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
							    <h3>Add Dividend</h3>
								<form action="/sri/dividenduseradd" method="post">
                                     {{ csrf_field() }}
									<div class="form-group">
									    <label for="id">Id</label>
									    <input type="text" name="id" class="form-control" id="id" placeholder="Id" value="{{ $user->id }}" readonly>
				  					</div> <!-- end form group   --> 	

									<div class="form-group">
									    <label for="name">Name</label>
									    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $user->first_name . " " .  $user->last_name }}" readonly>
				  					</div> <!-- end form group   --> 	
                                    
                                    <div class="form-group">
									    <label for="select1">Investment - <span class="redheavy">Please set the correct Org</span> </label>
									        <select class="form-control redheavy" id="investment1" name="investment1">
                                              @foreach($investments as $type)
                                                <option>{{ $type->investment_type }}</option>
                                              @endforeach
                                            </select>
				  					</div>


									 <div class="form-group">
									    <label for="amount">Dividend Amount</label>
									    <input type="text" class="form-control  " id="amount" name="amount" placeholder="Amount" >
				  					</div>
				  					<div class="form-group">
									    <label for="amount">Contribution Amount</label>
									    <input type="text" class="form-control  " id="amount2" name="amount2" placeholder="Amount" >
				  					</div>
				  					
									<div class="form-group">
									    <label for="amount">Dividend Period</label>
									    <select class="form-control" id="dividend_period" name="dividend_period">
									    	<option value="Quarterly" selected>Quarterly</option>
									    	<option value="Yearly">Yearly</option>
									    	<option value="Monthly">Monthly</option>
									    </select>
				  					</div>

				  					<!--
				  					 <div class="form-group mb-4">
									    <label for="amount">Date Transaction - <span class="redheavy">Please set the correct date</span> </label>
									    <input type="text" class="form-control" id="date" name="date" value="1/1/2020" placeholder="Amount" ="">
				  					</div>  
				  					-->
				  					
				  					<!-- end form group   --> 	
				  					 <div class="form-group mb-4">
									  
									    
									    <label for="date">Dividend Release Date - <span class="redheavy">Please set the correct date</span></label>
									        <select class="form-control  " id="date2" name="date2">
                          
				                                <!-- <option value="Dec 31, 2013">Dec 31, 2013</option>
				                                <option value="Dec 31, 2014">Dec 31, 2014</option>
				                                <option value="Dec 31, 2015">Dec 31, 2015</option>
				                                <option value="Dec 31, 2016">Dec 31, 2016</option>
				                                <option value="Dec 31, 2017">Dec 31, 2017</option>
				                                <option value="Dec 31, 2018">Dec 31, 2018</option>
				                                <option value="Dec 31, 2019">Dec 31, 2019</option> -->
                                              
                                                <option value="Mar 31, 2020">Mar 31, 2020</option>
                                                <option value="June 30, 2020">June 30, 2020</option>
                                                <option value="Sep 30, 2020">Sep 30, 2020</option>
                                                <option value="Dec 31, 2020">Dec 31, 2020</option>
                                                <option value="Mar 31, 2021">Mar 31, 2021</option>
                                                <option value="June 30, 2021">June 30, 2021</option>
                                                <option value="Sep 30, 2021">Sep 30, 2021</option>
                                                <option value="Dec 31, 2021">Dec 31, 2021</option>
                                             	<option value="Mar 31, 2022">Mar 31, 2022</option>
                                            </select>
									    
									    
									   
				  					</div> <!-- end form group 01/01/2020 to  2020-01-01 --> 	

									
	 									<input type="submit" value="Add Dividend" class="btn btn-outline-primary btn-block">


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

		    $('#dividend_period').change(function() {
		    	//$('#date2').empty();
		    	$dividendDate = $('#date2');
		    	console.log($('#dividend_period').val());
		    	$dividend_period = $('#dividend_period').val();

		    	switch($dividend_period){
		    		case "Quarterly":
		    			console.log("Quarterly case");
		    			var quarterlyOptions = {
		    			  "Mar 31, 2020": "Mar 31, 2020",
						  "Jun 30, 2020": "Jun 30, 2020",
						  "Sep 30, 2020": "Sep 30, 2020",
						  "Dec 31, 2020": "Dec 31, 2020",
						  "Mar 31, 2021": "Mar 31, 2021",
						  "Jun 30, 2021": "Jun 30, 2021",
						  "Sep 30, 2021": "Sep 30, 2021",
						  "Dec 31, 2021": "Dec 31, 2021",
						  "Mar 31, 2022": "Mar 31, 2022"
						};
						refreshDate($dividendDate,quarterlyOptions);
		    		break;

		    		case "Yearly":
		    			console.log("Yearly case");
		    			var yearlyOptions = {
		    			  "Dec 31, 2013": "Dec 31, 2013",
						  "Dec 31, 2014": "Dec 31, 2014",
						  "Dec 31, 2015": "Dec 31, 2015",
						  "Dec 31, 2016": "Dec 31, 2016",
						  "Dec 31, 2017": "Dec 31, 2017",
						  "Dec 31, 2018": "Dec 31, 2018",
						  "Dec 31, 2019": "Dec 31, 2019",
						  "Dec 31, 2020": "Dec 31, 2020",
						  "Dec 31, 2021": "Dec 31, 2021",
						  "Dec 31, 2022": "Dec 31, 2022"
						};
						
						refreshDate($dividendDate,yearlyOptions);
		    		break;

		    		case "Monthly":
		    			console.log("Monthly case");
		    			var monthlyOptions = {
		    			  "Jan 31, 2021": "Jan 31, 2021",
						  "Feb 28, 2021": "Feb 28, 2021",
						  "Mar 31, 2021": "Mar 31, 2021",
						  "Apr 30, 2021": "Apr 30, 2021",
						  "May 30, 2021": "May 30, 2021",
						  "Jun 30, 2021": "Jun 30, 2021",
						  "Jul 31, 2021": "Jul 31, 2021",
						  "Aug 31, 2021": "Aug 31, 2021",
						  "Sep 30, 2021": "Sep 30, 2021",
						  "Oct 31, 2021": "Oct 31, 2021",
						  "Nov 30, 2021": "Nov 30, 2021",
						  "Dec 31, 2021": "Dec 31, 2021",
						  "Jan 31, 2022": "Jan 31, 2022",
						  "Feb 28, 2022": "Feb 28, 2022",
						  "Mar 31, 2022": "Mar 31, 2022",
						};
						refreshDate($dividendDate,monthlyOptions);
		    		break;

		    	}
			});

		    function refreshDate($dateDropdown,$dateItems){

		    	$dateDropdown.empty();
				$.each($dateItems, function(key,value) {
				  $dateDropdown.append($("<option></option>")
				     .attr("value", value).text(key));
				});

		    }

	</script>
</body>
</html>