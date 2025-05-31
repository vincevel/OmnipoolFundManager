
@extends('layouts.customermaster')
@section('content')
<style>
 


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
 

<div class="container-fluid">
  <div class="row justify-content-end">
    <div class="col-md-4">
        <div id="updatebitcoinapp">
      <!--     <div class="form-group">
            <label for="bitcoin_address">Set Your Bitcoin Address:</label>
            <input class="form-control" type="text" name="bitcoin_address" id="bitcoin_address" value="{{ $user1->bitcoin_address }}" />
          </div>
          <div class="form-group">
             <a href="#" class="btn btn-primary d-block">Update</a> 
          </div> -->
          <custom-editbitcoin baddress="{{ $user1->bitcoin_address }}" uid="{{ $user1->id }}"></custom-editbitcoin>
        </div>  

       
    

    </div>
  </div>

</div>
 


<!-- form -->


  <div role="main" class="container">
    <ul class="form-section page-section list-unstyled">
    
 <!-- form -->


   
      @isset($tests)  
        @include('common.errors')
        @if (count($tests) > 0)
      

 

               @foreach ($tests as $test)
 

 

              @endforeach  
            
  
        @endif
    @endisset
    
   
   
        
      
      
    </ul>
  </div>
 
  
  <table style="1px solid black; width:100%" class="table table-bordered" id="summarytable">
          <thead>
            <tr>
             
              <td class=" "><h3>Summary</h3></td>
              <td class="text-right  "><h3>Amount</h3></td>
            </tr>
          </thead>
          <tbody>
 
                
             

                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Total Deposited
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $&nbsp{{ number_format($total_deposits,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 
                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Total Deferred
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $&nbsp{{ number_format($total_defers,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 

                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Total Balance
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $&nbsp{{ number_format($total_balance,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 

                 <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Current Tier
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
           
                            {{ ucwords($tier) }}
                        </div>
                      </div>
                    </td>
                </tr> 

           <!--      <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            New Deposit Payouts
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $ {{ number_format($this_month_transactions_payouts_total,2) }}
                        </div>
                      </div>
                    </td>
                </tr>  -->

               <!--  <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Old Deposit Payouts
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $ {{ number_format($prev_month_transactions_payouts_total,2) }}
                        </div>
                      </div>
                    </td>
                </tr>  -->

               <!--  <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Prev Months Total
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $ {{ number_format($prev_month_transactions_total,2) }}
                        </div>
                      </div>
                    </td>
                </tr>  -->

                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            This Month's Payout
                          </div>
                          <div>
                            <form>
                                <div class="form-group">
                                <label for="exampleFormControlSelect1">Payout or Deferred:</label>
                                <div id="updatedeferred1app">
                                  <custom-editdeferred1 isdeferred="{{ $user1->isDeferred1 }}" uid="{{ $user1->id }}" ></custom-editdeferred1>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $&nbsp{{ number_format($current_payouts_total,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 

                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Next Month's Payout
                          </div>
                          <div>
                            <form>
                                <div class="form-group">
                                <label for="exampleFormControlSelect1">Payout or Deferred:</label>
                                  <div id="updatedeferred2app">
                                     <custom-editdeferred2 isdeferred="{{ $user1->isDeferred2 }}" uid="{{ $user1->id }}"></custom-editdeferred2>
                                  </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         $&nbsp{{ number_format($next_month_payout_total,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 
           
          </tbody>
        </table> 
        <br>
        <br>

 <table style="1px solid black; width:100%" class="table table-bordered" id="searchtable">
          <thead>
            <tr>
              <!-- <td>ID</td> -->
              <td style="width: 50px" class="">Date</td>
              
              <td> </td>
              <td>Amount</td>
            </tr>
          </thead>
          <tbody>
           <!--  <tr  >

              <td class="px-3">2021-10-09</td>
              <td class="px-3">2005.30</td>
              <td class="px-3">1</td>
            </tr> -->

            @php
                  $running_balance = $total_balance;
                  $first = true;

            @endphp
             
            @isset($transactions)

              @foreach ($transactions as $transaction)
                @php

                  //list($year,$month,$day) = explode("-",$transaction->date_transaction);
                  //$formatted_date_1 = strtotime($month ."/". $day . "/" . $year);

                  //$date = strtotime($formatted_date_1);
                  $date = strtotime($transaction->date_transaction);

                  $day = date('d',$date);
                  $month = date('M',$date);
                  //$year = date('Y',$date);

                   

                @endphp
                <tr>
                    <td  style="border-right:none">
                      <!-- <div>{{ $transaction->id }}</div> -->
                      <div class="d-flex flex-column">
                        <div class="text-left">
                         <!--  <div class="">{{ $transaction->date_transaction }}</div> -->
                          <div style="font-size:larger" class="text-muted text-uppercase">{{ $month }}</div>
                          <div class="">{{ $day }}</div>
                         <!--  <div class=""> </div> -->
                        </div>
                      </div>
                    </td>
                    <td  style="border-right:none">
                    
                      <div class="d-flex flex-xs-column flex-sm-column flex-md-row">
                     <!--  <div class="" ><i class="fa-solid fa-plus  rounded-circle" style="border:2px solid black"></i></div>  -->
                      
                       <!--  <i class="fa-solid fa-plus" style=""></i> -->
                         <div class="mr-4 mt-2">
                           <!--  <i class="fa-solid fa-plus fa-2x" style=""></i> -->
                           @if ($transaction->transaction_type_id == 1)
                           <img class="icondisplay" style="width: 40px; opacity: 0.3" src="{{ asset('image/plus.png') }}" alt="">
                           @elseif ($transaction->transaction_type_id == 5)
                           <img class="icondisplay" style="width: 40px; opacity: 0.3" src="{{ asset('image/plus.png') }}" alt="">
                              
                            @else
                           <img class="icondisplay" style="width: 40px; opacity: 0.3" src="{{ asset('image/minus.png') }}" alt="">
                             
                            @endif 
                          </div>
                     


                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            @if ($transaction->transaction_type_id == 1)
                              Deposit
                            @elseif ($transaction->transaction_type_id == 4)
                              Withdraw  
                            @elseif ($transaction->transaction_type_id == 5)
                              Bonus
                            @else
                              Deferred
                            @endif
                          </div>
                          <div class="text-muted" >
                            Verified
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >

                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
                         <div>$&nbsp{{ number_format($transaction->amount,2) }}</div>
                        </div>
                        <div class="text-right text-muted">
                          @php
                         
                             //if ($transaction->transaction_type_id == 4){
                              //  $residual = $running_balance + //($transaction->amount); 
                             //} else {
                             $residual = $running_balance - $transaction->amount;
                             //}
                             $running_balance = $residual;
                             $run_bal_orig = $running_balance + $transaction->amount;
                          @endphp

                         <div>$&nbsp{{ number_format($transaction->running_balance,2) }}</div>
                        
                         @php
                  
                          @endphp

                        </div>
                      </div>
                    </td>
                </tr>  
              @endforeach
            @endisset
          </tbody>
        </table> 



        <br>
        <br>


        @if (Auth::user()->admin == 1234213)
        <section class="jumbotron text-center">
   <form action="/dividenduser" method="post" name="" id="" accept-charset="utf-8" autocomplete="on">
       {{ csrf_field() }}
      <h1>Accounts - Search For User</h1>
      <p class="lead text-muted">Find the First Name, Last Name or Email Address of The Client Here:</p>
      <div class="row">
       
        <div class="col-sm-12 col-md-6 offset-md-3">
       
        </div>
 
      </div>
         
    <div id="searchapp" class="container" style="">
      <!--  -->
        <!-- <custom-searchresult></custom-searchresult> -->
        <!-- <a href="#" class="btn btn-primary my-2">Search</a> -->
       <!--  <a href="/sri/backend" class="btn btn-secondary my-2">Back to The Previous Page</a> -->
      <!-- </p> -->
    </div>

    @if (Auth::user()->id == 1241234)
    <div id="searchapp2" class="container" style="">
      SECRET COMPARTMENT
      <!--  -->
        <!-- <custom-searchresult></custom-searchresult> -->
        <!-- <a href="#" class="btn btn-primary my-2">Search</a> -->
       <!--  <a href="/sri/backend" class="btn btn-secondary my-2">Back to The Previous Page</a> -->
      <!-- </p> -->
    </div>
    @endif


    </form>
  </section>
    @endif
  <br>
  <br>
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
     
      
      $('#transactiontable').DataTable({
       
      });
    }

      function initDataTables2(){
     
      $('#searchtable2').DataTable({
         
      });
       
    }
  </script>
  

  <script>
    
    // Define a new global component called button-counter
    // searchapp.component('custom-header', {
    //   delimiters: ['${','}'],
    //   props: [],
    //   methods: {
    //     deleteTransaction(event) {
    //         event.preventDefault();
    //           alert(this.ltrans_id)
    //           axios.post('/deletetransactions',{
    //             trans_id: this.ltrans_id
    //           }) 
    //           .then(results => {
    //           })
    //     }
    //   },
    //   data() {
    //     return {
    //       count: 0,
    //       ltrans_id: this.trans_id
    //     }
    //   },
    //   template: `
    //   zzasdfsadfs "sdfa" sdfasfdsafsadfasd 
    //   `
    // })
    

     // Define a new global component called button-counter
   
  
  </script>
<!--  <custom-master></custom-master>
 -->  <script>
    $(document).ready(function() {
       $('#searchtable').DataTable({
        "order": [],
         "ordering": false 
      });

        initDataTables(); 
    } );

  

  </script>
  <script type="text/javascript">
    
    if (document.querySelector('#updatebitcoinapp')) {
    
      const updatebitcoinapp = Vue.createApp({
        delimiters: ['${','}'],
        data() {
         return {
            
         }
        },
      })

    updatebitcoinapp.component('custom-editbitcoin', {
      delimiters: ['${','}'],
      created() {
               
      },
      props: ['baddress','uid'],
      methods: {
        loaddata2(event) {
          //alert(this.getNum)
          event.preventDefault();
           axios.post("/api/update/baddress",{
              baddress: this.lbaddress,
              uid: this.luid,
           }) 
          .then(results => {
            // this.variants = results.data.variant
          })
          
        },
        loaddata(event) {
          
        }
      },
      computed: {

      },
      data() {
        return {
          lbaddress: this.baddress,
          luid: this.uid,
        }
      },
      template: `   
        <div class="form-group">
          <label for="bitcoin_address">Set Your Bitcoin Address:</label>
          <input class="form-control" type="text" v-model="lbaddress" name="bitcoin_address" id="bitcoin_address" />
        </div>
        <div class="form-group">
          <a href="#" class="btn btn-primary d-block" @click="loaddata2">Update</a> 
        </div>
      `
    }) 

    updatebitcoinapp.mount('#updatebitcoinapp')

  }

    if (document.querySelector('#updatedeferred1app')) {
    
      const updatedeferred1app = Vue.createApp({
        delimiters: ['${','}'],
        data() {
         return {
            
         }
        },
      })

    updatedeferred1app.component('custom-editdeferred1', {
      delimiters: ['${','}'],
      created() {
               
      },
      props: ['isdeferred','uid'],
      methods: {
        loaddata2(event) {
          //alert(this.getNum)
          event.preventDefault();
           axios.post("/api/update/deferred1",{
              isdeferred: this.lisdeferred,
              uid: this.luid,
           }) 
          .then(results => {
            // this.variants = results.data.variant
          })
          
        },
        loaddata(event) {
          
        }
      },
      computed: {

      },
      data() {
        return {
          
          lisdeferred: this.isdeferred,
          luid: this.uid,
        }
      },
      template: `   
               <select @change="loaddata2" class="form-control form-select" v-model="lisdeferred" id="exampleFormControlSelect1" >
                    <option value="0">Payout</option>
                    <option value="1">Deferred</option>
               </select>
      `
    }) 

    updatedeferred1app.mount('#updatedeferred1app')

  }

  if (document.querySelector('#updatedeferred2app')) {
    
      const updatedeferred2app = Vue.createApp({
        delimiters: ['${','}'],
        data() {
         return {
            
         }
        },
      })

    updatedeferred2app.component('custom-editdeferred2', {
      delimiters: ['${','}'],
      created() {
               
      },
      props: ['isdeferred','uid'],
      methods: {
        loaddata2(event) {
          //alert(this.getNum)
          event.preventDefault();
           axios.post("/api/update/deferred2",{
              isdeferred: this.lisdeferred,
              uid: this.luid,
           }) 
          .then(results => {
            // this.variants = results.data.variant
          })
          
        },
        loaddata(event) {
          
        }
      },
      computed: {

      },
      data() {
        return {
          lisdeferred: this.isdeferred,
          luid: this.uid,
        }
      },
      template: `   
          <select class="form-control form-select" v-model="lisdeferred" @change="loaddata2" id="exampleFormControlSelect1" >
            <option value="0">Payout</option>
            <option value="1">Deferred</option>
          </select>
      `
    }) 

    updatedeferred2app.mount('#updatedeferred2app')

  }



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