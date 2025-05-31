<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-US"  class="supernova">


 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=1" />
 
<title>Email Registration Info</title>
  <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style type="text/css">
  
  .navcolor {
    background-color: #1c4221 !important;
  }

  .redborder {
    border: 1px solid red;
  }

  .whitebg {
    background-color: white;
  }

  .list-unstyled {
  list-style: none;
  }

</style>
 
</head>
<body>
<header>
  <div class="collapse navcolor" id="navbarHeader">
    <div class="container navcolor">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
      
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Contact</h4>
          <ul class="list-unstyled">
          
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navcolor shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        <strong></strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>

<section class="jumbotron text-center">
   <form action="/sri/dividenduser" method="post" name="" id="" accept-charset="utf-8" autocomplete="on">
       {{ csrf_field() }}
    <div class="container">
      <h1>Dividends - Search For User</h1>
      <p class="lead text-muted">Find the First Name, Last Name or Email Address of The Investor Here:</p>
      <p>
      <div class="row">
       
        <div class="col-sm-12 col-md-6 offset-md-3">
          <div class="form-group">
            <input type="input" class="form-control" id="input_3" name="email" aria-describedby="emailHelp" placeholder="Enter email, first name or last name">
          </div>
        </div>
 
      </div>
         <button id="input_2" type="submit" class="btn btn-primary my-2" data-component="button" data-content="">
              Search
            </button>
        <!-- <a href="#" class="btn btn-primary my-2">Search</a> -->
        <a href="/sri/backend" class="btn btn-secondary my-2">Back to The Previous Page</a>
      </p>
    </div>
    </form>
  </section>



<!-- form -->


  <div role="main" class="container">
    <ul class="form-section page-section list-unstyled">
    
 <!-- form -->


   
      @isset($tests)  
        @if (count($tests) > 0)
      
        @include('common.errors')



       

          <!-- form -->


          
    
              <div class="container">
                <div class="row mb-3">
                  
                  <div class="col-sm-2"><p>First Name</p></div>
                  <div class="col-sm-2"><p>Last Name</p></div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-1"><p>View</p></div>
                  <div class="col-sm-3"><p>Email</p></div>
                  <div class="col-sm-3">
                    
                           <p>Add - Wallet - Reinvest - Merge</p> 
              
                  </div>
                 
               

                </div>


               @foreach ($tests as $test)
<form target="_blank"  action="{{ url('dividenduser/'.$test->id) }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
       
                    <div class="row no-gutters mb-2">
                      <!-- <div class="col-sm-12 col-md-4"> -->
                      <div class="col-sm-2">
                        <input class="form-control" value="{{ ucwords($test->first_name) }}"> 
                      </div>
                      <!-- <div class="col-sm-12 col-md-3"> -->
                      
                      <div class="col-sm-2">
                        <input class="form-control" value="{{ ucwords($test->last_name) }}"> 
                      </div>
                      <!-- <div class="col-sm-12  col-md-2 mr-2">                      -->
                      
                      <div class="col-sm-1">
                       <input class="form-control" value="{{ $test->id}}"> 
                      </div>
                      <!-- <div class="col-sm-12 col-md-2"> -->

                      <div class="col-sm-1">
                        <div class="btn-group" role="group" aria-label="Basic example">
                        
                         @if (Auth::user()->id == 20) 
                     
                               <a class="btn btn-warning form-control"   href="/sri/dividenduser/list2/{{ $test->id }}" target="_blank">Edit</a> 
                         
                         @else 
                              <a class="btn btn-primary form-control"   href="/sri/dividenduser/list/{{ $test->id }}" target="_blank">View</a>  

                         @endif



                       </div>
                      </div>


                       <div class="col-sm-3">
                          
                            <input class="form-control" value="{{ $test->user_email }}"> 
                       </div> 

                       <div class="col-sm-3">
                          <div class="container-fluid m-0 p-0 ">
                                <div class="btn-group " role="group" aria-label="Basic example">
                                   <button id="input_2" type="submit" class="btn btn-sm btn-outline-secondary">
                                  Add Dividend
                                  </button>
                                </form>
                                    <form target="_blank" action="{{ url('dividenduser2/'.$test->id) }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
                
             <button id="input_2" type="submit" class="btn btn-sm btn-outline-secondary">
              Add To Wallet
            </button>  
                        </form>

                         <form target="_blank" action="{{ url('dividenduser/reinvest/'.$test->id) }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
                      
                            <button id="input_2" type="submit" class="btn btn-sm btn-secondary btn-outline-secondary">
                                Reinvest
                            </button>
                    
                    </form>
                                 <form target="_blank" action="{{ url('dividendusermerge/'.$test->id) }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
                
             <button id="input_2" type="submit" class="btn btn-sm btn-outline-secondary">
              Merge Account
            </button>  
                        </form>
                                 
 

                          </div> 
                       </div> 
                  </div>
                   </div>
                  <!-- <input style="width:300px" value="{{ ucwords($test->first_name) . "," . ucwords($test->last_name) . ",". $test->id .",".  $test->user_email }}"> -->  
                   
            
                  
                  
                  
              
                 
                  
    
         <!-- form -->

              @endforeach  
            
             </div>
        
          <br>
          <br>
        </div>
        @endif
    @endisset
        <div class="container mb-5">   

         <a href="/sri/backend" class="btn btn-primary " data-component="button" data-content="">Back</a> 
        </div>
    
   
   
        
      
      
    </ul>
  </div>
 
 
 <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
 