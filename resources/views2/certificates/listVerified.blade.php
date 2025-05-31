<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Send Joint Venture Certificate</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
</head>

<body>
<nav class="navbar navbar-dark bg-primary">
      <a class="navbar-brand p-3 btn btn-primary lead" href="#">Joint Venture Certificate</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          
          
          <li class="nav-item active">
            
          </li>
          <li class="nav-item">
           
          </li>
          <li class="nav-item">
           
          </li>
          <li class="nav-item dropdown">
        
          </li>
        </ul>
       
      </div>
    </nav>
      <br>

      
      
<div class="container">
   @isset($transactions)  
        @if (count($transactions) > 0)
            <ul class="list-group mb-5">
                    <li class="list-group-item">
                        <ul class="list-group list-group-horizontal">
                            <form action="/sri/certificate" method="post" class="form-inline justify-content-center ml-auto">
                                  {{ csrf_field() }}
					        	<input type="text" name="search" class="form-control mb-2 mr-2" placeholder="Search">
						      
						        <button class="btn btn-primary mb-2">Search</button>

					</form>

                        </ul>
                    </li>
                    
                     <li class="list-group-item">
                        <ul class="pagination">
                           
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/A">A</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/B">B</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/C">C</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/D">D</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/E">E</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/F">F</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/G">G</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/H">H</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/I">I</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/J">J</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/K">K</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/L">L</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/M">M</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/N">N</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/O">O</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/P">P</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/Q">Q</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/R">R</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/S">S</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/T">T</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/U">U</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/V">V</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/W">W</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/X">X</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/Y">Y</a></li>
                            <li class="page-item"><a class="page-link" href="/sri/certificate/alphabet/Z">Z</a></li>


                             
                     
                          </ul>
                    </li>
                
                
                
                    <li class="list-group-item">
                        <ul class="list-group list-group-horizontal">
                            
                          <li class="list-group-item flex-fill btn btn-light">id</li>
                             <li class="list-group-item flex-fill">Date Transaction</li>
                          
                          <li class="list-group-item flex-fill">Name</li>
                          
                          <!-- 
                          <li class="list-group-item flex-fill">Last Name</li>
                          -->
                          
                          
                          <li class="list-group-item flex-fill">Amount</li>
                          <li class="list-group-item flex-fill">Investment Type</li>
                       
                          
                          <li class="list-group-item flex-fill">Status</li>
                           <li class="list-group-item flex-fill"></li>
                           
                           <li class="list-group-item flex-fill"></li>
                            <li class="list-group-item flex-fill">
                                
                          
                            <a href="/sri/backend" class="btn btn-success btn block">Back</a>
                     
                            </li>
                        </ul>    
                    </li>
                    
                
   
            @foreach ($transactions as $transaction)
            
               
                    
                      <li class="list-group-item">
                          
                        <ul class="list-group list-group-horizontal">
                     
                          <li class="list-group-item flex-fill">{{ $transaction->id }}</li>
                                   <li class="list-group-item flex-fill">{{ $transaction->date_transaction }}</li>
                          <li class="list-group-item flex-fill">{{ ucwords($transaction->last_name) . ", " . ucwords($transaction->first_name) }}</li>
                         
                         
                         <!-- <li class="list-group-item flex-fill"></li>
                         -->
                          
                          <li class="list-group-item flex-fill">{{ $transaction->amount }}</li>
                          <li class="list-group-item flex-fill">{{ $transaction->investment_type }}</li>
                        
                            <li class="list-group-item flex-fill">
                            
                                {{ $transaction->status }}
                        
                            </li>
                          
                          
                             <li class="list-group-item flex-fill">
                     <form action="/sri/certificate/{{ $transaction->id }}" method="GET">
                        {{ csrf_field() }}
                        
                        <button class="btn btn-primary">View Cert</button>
                    </form>
                    </li>
                         <li class="list-group-item flex-fill">
                        <form action="/sri/certificate/mail/{{ $transaction->id }}" method="POST" >
                            {{ csrf_field() }}
                            
                            <button class="btn btn-info">Mail Cert</button>
                        </form>
                        </li>
                    
                        @if ($transaction->sent_certificate == 0 )
                    
                     <li class="list-group-item flex-fill">
                           
                                <span class="badge badge-danger">Not Sent</span>
                      
                         </li>
                    
                        @elseif ($transaction->sent_certificate == 1 )
                        
                    <li class="list-group-item flex-fill"><span class="badge badge-success">Sent</span></li>
                        @endif
                         
                        </ul>
                                              
                      
                       
                      
                      </li>
                  
                    
               
    
                 
                    
                       
                   
          
            @endforeach
                <li class="list-group-item">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item flex-fill"> 
                            <a href="/sri/backend" class="btn btn-success btn block">Back</a>
                        </li>
                    </ul>
                </li>
             </ul>
        @endif
  @endisset
  </div>
 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

 </body>

</html>
