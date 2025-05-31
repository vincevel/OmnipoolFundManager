
@extends('layouts.master')
@section('content')
<style>
  .whitebg {
    background-color: white;
  }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('searchuser')
 

<section class="jumbotron text-center">
   <form action="/dividenduser" method="post" name="" id="" accept-charset="utf-8" autocomplete="on">
       {{ csrf_field() }}
    <div id="searchapp" class="container" style="//background-color: red">
      <h1>Accounts - Search For User</h1>
      <p class="lead text-muted">Find the First Name, Last Name or Email Address of The Client Here:</p>
      <p>
      <div class="row">
       
        <div class="col-sm-12 col-md-6 offset-md-3">
       
        </div>
 
      </div>
         
        <custom-searchresult></custom-searchresult>
        <!-- <a href="#" class="btn btn-primary my-2">Search</a> -->
       <!--  <a href="/sri/backend" class="btn btn-secondary my-2">Back to The Previous Page</a> -->
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
    
   
   
        
      
      
    </ul>
  </div>
 
 <table style="1px solid black; width:100%" class="table table-striped table-bordered" id="searchtable">
          <thead>
            <tr>
              <td>Date</td>
              <td>Time</td>
              <td>Amount</td>
              <td>Bitcoin</td>
              <td>Percentage</td>
            </tr>
          </thead>
          <tbody>
            <tr  >

              <td class="px-3">2021-10-09</td>
              <td class="px-3">7:19:00 AM</td>
              <td class="px-3">2005.30</td>
              <td class="px-3">0.0364607800 </td>
              <td class="px-3">0.03</td>
            </tr>

            <tr  >

              <td class="px-3">2021-10-09</td>
              <td class="px-3">7:19:00 AM</td>
              <td class="px-3">2005.30</td>
              <td class="px-3">0.0364607800 </td>
              <td class="px-3">0.03</td>
            </tr>

             <tr  >

              <td class="px-3">2021-10-09</td>
              <td class="px-3">7:19:00 AM</td>
              <td class="px-3">2005.30</td>
              <td class="px-3">0.0364607800 </td>
              <td class="px-3">0.03</td>
            </tr>
          </tbody>
        </table> 

  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

  <script src="https://unpkg.com/vue@next"></script>


  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js" integrity="sha512-lTLt+W7MrmDfKam+r3D2LURu0F47a3QaW5nF0c6Hl0JDZ57ruei+ovbg7BrZ+0bjVJ5YgzsAWE+RreERbpPE1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!--  <script src="https://unpkg.com/vue@3.0.5/dist/vue.global.prod.js"></script> -->
  
  <script>
      function initDataTables(){
      $('#searchtable').DataTable();
      $('#searchtable2').DataTable();
      $('#transactiontable').DataTable();
    }
  </script>
  

  <script>
   
    if (document.querySelector('#searchapp')) {
     const searchapp = Vue.createApp({
        delimiters: ['${','}'],
        data() {
         return {
            
         }
        },
    })

    // Define a new global component called button-counter
    searchapp.component('custom-searchresult', {
      delimiters: ['${','}'],
      created() {
       //initDataTables();              
      },
      props: ['email'],
      methods: {
        loaddata2(event) {
          // alert("button clicked");
          //alert(this.lamount + " - " + this.ltid)
          //alert(this.getNum)
          initDataTables();  
          this.firstTime = false;
          //initDataTables(); 

          event.preventDefault();
            axios.post('/dividenduser',{
                email: this.lemail,
            }) 
           .then(results => {
             //console.log(results.data)
             if (results.data == 0){
               //this.items[0] = "No Results Found";
               this.items = []
             } else {

               // $('#searchtable2').DataTable();
               // initDataTables();
               this.items = results.data
               
               console.log(this.items)
             }
           })
          
        },
        loaddata(event) {
          
         
          
        },
        showTransaction(a,event) {
            //$('#transactiontable').DataTable();
            //alert(a);
            event.preventDefault();

              axios.post('/gettransactions',{
                email: a,
              }) 
             .then(results => {
               //console.log(results.data)
               if (results.data == 0){
                 //this.items[0] = "No Results Found";
                 this.items = []
               } else {

                 // $('#searchtable2').DataTable();
                 // initDataTables();
                 this.transactions = results.data
                 
                 console.log(this.items)
               }
             })
            
            //pull data from here. pull what data? based on button pressed?

            if (this.firstTimeTransactions == true){
      

            }
            this.firstTimeTransactions = false;
            //initDataTables();
            initDataTables();  
        }
      },
      computed: {
        

      },
      data() {
        return {
          count: 0,
          leligible: this.eligible,
          lemail: this.email,
          btnText: "Update",
          firstTime: true,
          firstTimeTransactions: true,
          items: [],
          transactions: []
        }
      },
      template: `
   <div class="form-group">
            <input type="input" class="form-control" id="input_3" name="email" aria-describedby="emailHelp" v-model="lemail" placeholder="Enter email, first name or last name">
          </div>

<div class="text-center">
    <button @click="loaddata2" id="input_2" type="submit" class="btn btn-primary my-2" data-component="button" data-content="">Search</button>
</div>
  <br>



  <div v-if="items.length == 0">
     <div class="container" style="background-color: white">
      <div class="col" v-if="firstTime == true"></div>  
      <div class="col" v-else>No Items Found</div>  
    </div>

  </div>
  <div v-else class="container-fluid" >
 
        <table id="searchtable2" style="1px solid black; width:100%" class="table table-striped table-bordered whitebg table-hover table-responsive"  >
          <thead>
            <tr>
              <td>Name</td>
              <td>Id</td>
              <td>Email</td>
              <td>View Account</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items">

              <td class="px-3">$\{ item.name \}</td>
              <td class="px-3">$\{ item.id \}</td>
              <td class="px-3">$\{ item.email \}</td>
              <td class="px-3"><input @click="showTransaction(item.name,$event)" type="submit" value="View" class="btn btn-primary"></td>
            </tr>
          </tbody>
        </table> 
        <br>
        <br>
 
  </div>

  <div v-if="firstTimeTransactions == true">
     

  </div>
  <div v-else class=" " style="background-color: white; border:1px solid black"> 
        <br>
        <h1>View Transactions - $\{ transactions[0].email \} </h1>
        <table id="transactiontable" style="1px solid black; width:100%" class="table table-striped table-bordered table-hover table-responsive"  >
          <thead>
          <tr>
            <td>Date</td>
            <td>Time</td>
            <td>Amount</td>
            <td>Bitcoin Amount</td>
            <td>Percentage Of Account</td>
          </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in transactions">

              <td class="px-3">$\{ transaction.date_transaction \}</td>
              <td class="px-3">$\{ transaction.time_transaction \}</td>
              <td class="px-3">$\{ transaction.amount \}</td>
              <td class="px-3">$\{ transaction.bitcoin_amount \}</td>
              <td class="px-3">$\{ transaction.percentage_of_account \}</td>
               
            </tr>
          </tbody>
        </table> 
     
  </div>

  `
    })

    searchapp.mount('#searchapp');
  
  }
  
  </script>

  <script>
    $(document).ready(function() {
        initDataTables(); 
    } );

  

  </script>

<!--   
      
      <div class="row" style="border-bottom: 1px solid black">
        <div class="col">Name</div>
        <div class="col">Email</div>
        <div class="col">View</div>
      </div>
      <div class="row" v-for="item in items" style="border-bottom: 1px solid black" >
        <div class="col">$\{ item.name \}</div>
        <div class="col">$\{ item.id \}</div>
        <div class="col">$\{ item.email \}</div>
        <div class="col">View</div>
         
      </div> -->


 <!--  <table>


  <tr v-else v-for="item in items">

    <td>$\{ item.first_name \}</td>
    <td>$\{ item.last_name \}</td>
    <td>$\{ item.id \}</td>
    <td>$\{ item.user_email \}</td>
    <td>View</td>
     
  </tr>
</table> -->

   <!-- //First Name Last Name ID View Email -->
 <!--    <tr v-if="items.length" === 0>
    <td>No Data</td>
  </tr> -->



@endsection