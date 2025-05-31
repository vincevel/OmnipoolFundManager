<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>View all SRIs</title>
   <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />

<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>

    <style>
        .orange {
            color: #fa7d09;
        }
        
        .opac {
            opacity: 1;
            border-radius: 5px !important;
        }
        
    </style> 
</head>

<body>
 
  
<div class="container-fluid">
   
    <div class="container col-md-6">

    <div class="row">
        <div class="col">
            <h1 class="mt-3 ml-3">View all SRIs</h1>
        </div>
    </div>
    
 
    <div class="row">
        <div class="col">
   		@isset($data)  
        	@if (count($data) > 0)
            
            <table id="sri_table" name="sri_table" class="table-sm table-striped table-bordered">
            	<thead>
               
                <tr>
                    <th>SRI</th> 
                    <th>Outstanding Amount</th>
                </tr>
       	        </thead>
            <tbody>
                
   
            @foreach ($data as $item)
            <tr>
                <td> {{ $item[0] }} </td> 
                <td class="text-right"> {{ number_format($item[1], 2, '.', ',') }} </td> 
   
            </tr>

            @endforeach
            
             
        @endif
  @endisset
    
    
    </tbody>
    </table>
    
 
         
        
            </div> <!-- end col -->
        </div>   <!-- end row -->
        <div class="row">
          <div class="col">
            <h3 class=" ">Total Oustanding: {{ $total }} </h1>
          </div>
        </div>
         <div class="row">
          <div class="col">
            <h3 class=" ">Total Wallet Balance: {{ $total_wallet }} </h1>
          </div>
        </div>     
        <div class="row">
          <div class="col">
            <h3 class=" ">Total Outstanding + Wallet Balance: {{ $total_all  }} </h1>
          </div>
        </div>  

         <div class="row">
          <div class="col">

        <table class="table table-sm">
              <tr>
               <td>   </td>
               <td></td>
          </tr>  
          <tr>
              
              <td>
                  <a href="/sri/orgnetreportmain" class="form-submit-button" data-component="button" data-content="">Back</a> 
              </td>
              <td></td>
               <td></td>
           </tr>
          </table>
             </div>
        </div> 

    </div> <!-- end container --> 
 
</div> <!-- end main container -->                 
    
  
  
 <script
              src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
              integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
              crossorigin="anonymous"></script>
   <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
 

 <script>
$(document).ready(function() {
    $('#sri_table').DataTable( {
        "paging":   false
 
    } );
} );

</script>
    


 </body>

</html>
