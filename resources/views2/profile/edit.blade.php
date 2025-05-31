<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit My Profile</title>
 <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>

	 #search {
	  
	 }
 	
	 .red {
	     border: 1px solid red;
	 }
	
</style>
</head>
<body id="home">
<div class="container-fluid">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
        {{ $error }}
         </div>
        @endforeach
    @endif
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            
            
            
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
    						<label for="first_name">Email</label>
    					    <input type="text" name="user_email" class="form-control" id="user_email" placeholder="Email" value="{{ $user->user_email }}" readonly >
    				  	</div> <!-- end form group   --> 
                        
    				    
    				  	
    				  	
    				  
    				</div>
                    
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 1 -->
               <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - First Name</h3>
                    </div>
                    <div class="card-body">
                            <div class="form-group">
    						<label for="first_name">First Name</label>
    					    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="{{ $user->first_name }}" >
    				  	</div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save </button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 1 -->
               <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Last Name</h3>
                    </div>
                    <div class="card-body">
                           <div class="form-group">
    						<label for="last_name">Last Name</label>
    					    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" value="{{ $user->last_name }}" >
    				  	</div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save </button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 1 -->
               <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Middle Name</h3>
                    </div>
                    <div class="card-body">
                              <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" id="middle_name" placeholder="Middle Name" value="{{ $user->middle_name }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save </button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
           
                
                <!-- 2 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Phone Number </h3>
                    </div>
                    <div class="card-body">
                         <div class="form-group">
                            <label for="last_name">Phone Number</label>
                            <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number" value="{{ $user->phone_no }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save </button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Birthday</h3>
                    </div>
                    <div class="card-body">
                       <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="text" name="birthday" class="form-control" id="birthday" placeholder="01/01/2020" value="{{ $bday }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Address Line 1</h3>
                    </div>
                    <div class="card-body">
                       <div class="form-group">
                            <label for="address_line1">Address Line 1</label>
                            <input type="text" name="address_line1" class="form-control" id="address_line1" placeholder="Address Line 1" value="{{ $user->address_line1 }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Address Line 2</h3>
                    </div>
                    <div class="card-body">
                       <div class="form-group">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" name="address_line2" class="form-control" id="address_line2" placeholder="Address Line 2" value="{{ $user->address_line2 }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - City</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="address_line2">City</label>
                            <input type="text" name="city" class="form-control" id="city" placeholder="City" value="{{ $user->city }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - State/Province</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="state_province">State or Province</label>
                            <input type="text" name="state_province" class="form-control" id="state_province" placeholder="State or Province" value="{{ $user->state_province }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Zip Code</h3>
                    </div>
                    <div class="card-body">
                         <div class="form-group">
                            <label for="postal_zip_code">Zip Code</label>
                            <input type="text" name="postal_zip_code" class="form-control" id="postal_zip_code" placeholder="Zip Code" value="{{ $user->postal_zip_code }}" >
                        </div> <!-- end form group   -->
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Country</h3>
                    </div>
                    <div class="card-body">
                         <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" name="country" class="form-control" id="country" placeholder="Country" value="{{ $user->country }}" >
                        </div> <!-- end form group   --> 
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Beneficiary First Name</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="country">Beneficiary First Name</label>
                            <input type="text" name="beneficiary1_first_name" class="form-control" id="beneficiary1_first_name" placeholder="Beneficiary First Name" value="{{ $user->beneficiary1_first_name }}" >
                        </div> <!-- end form group   -->
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Beneficiary Middle Name</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="country">Beneficiary Middle Name</label>
                            <input type="text" name="beneficiary1_middle_name" class="form-control" id="beneficiary1_middle_name" placeholder="Beneficiary Middle Name" value="{{ $user->beneficiary1_middle_name }}" >
                        </div> <!-- end form group   -->
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Beneficiary Last Name</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="country">Beneficiary Last Name</label>
                            <input type="text" name="beneficiary1_last_name" class="form-control" id="beneficiary1_last_name" placeholder="Beneficiary Last Name" value="{{ $user->beneficiary1_last_name }}" >
                        </div> <!-- end form group   -->
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
                <!-- 3 -->
                <div class="card my-5 border border-primary">
                    <form action="{{ route('profile.save') }}" method="post">
                    {{ csrf_field() }}    
                    <div class="card-header pt-3">
    				    <h3>Edit My Profile - Beneficiary Relationship</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="country">Beneficiary Relationship</label>
                            <input type="text" name="beneficiary1_relationship" class="form-control" id="beneficiary1_relationship" placeholder="Beneficiary Relationship" value="{{ $user->beneficiary1_relationship }}" >
                        </div> <!-- end form group   -->
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <a href="/sri/login" class="btn btn-success">Cancel</a>
                
            			<button type="submit" class="btn btn-primary" >Save</button>
            			</div>
                    </div> <!-- card footer -->
                    <input type="hidden" name="id" class="form-control" id="id"  value="{{ $user->id }}" >
                    </form>
                </div> <!-- end card -->
                
        </div>  <!-- end col --> 
        
       
    </div> <!-- end row --> 
     
	<!-- form section -->
</div> <!-- end container -->      
 


<!--   -->
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

     <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
	
	<script>
			//Get current year for copyright
			$('#year').text(new Date().getFullYear());

			//init scrolspy
		 
             $('#birthday').datepicker({
            uiLibrary: 'bootstrap4'
        });

	</script>
</body>
</html>