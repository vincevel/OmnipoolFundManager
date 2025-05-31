
@extends('layouts.master')

@section('header1')
<h1 class="m-0">Dashboard</h1>
@endsection

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

@if (Auth::user()->admin != 1) 
<div class="container-fluid">
  <div class="row justify-content-end">
    <div class="col-md-4">
        <div id="updatebitcoinapp">
      <!--     <div class="form-group">
            <label for="bitcoin_address">Set Your Bitcoin Address:</label>
            <input class="form-control" type="text" name="bitcoin_address" id="bitcoin_address" value="{{ $user->bitcoin_address }}" />
          </div>
          <div class="form-group">
             <a href="#" class="btn btn-primary d-block">Update</a> 
          </div> -->
         
          <custom-editbitcoin baddress="{{ $user->bitcoin_address }}" uid="{{ $user->id }}"></custom-editbitcoin>
          
        </div>  

       
    

    </div>
  </div>

</div>
@endif
 


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
 
  @if (Auth::user()->admin != 1)
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

                 <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <div class="" style="font-size:larger">
                            Amount Needed For Next Tier
                          </div>
                        </div>
                      </div>
                   </td>
                    <td >
                      <div class="d-flex flex-column">
                        <div class="text-right" style="font-size:larger">
           
                            $&nbsp{{ number_format($amount_to_next_tier,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 

                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                         <!--  <div class="" style="font-size:larger">
                            This Month's Payout
                          </div> -->
                          <div class="" style="font-size:larger">
                            This Month's Payout
                          </div>
                          <div>
                            <form>
                                <div class="form-group">
                                <label for="exampleFormControlSelect1">Payout or Deferred:</label>
                                <div id="updatedeferred1app">
                                  <custom-editdeferred1 isdeferred="{{ $payouts[0]->isDeferred }}" uid="{{ $user->id }}" ></custom-editdeferred1>
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
                         $&nbsp{{ number_format($payouts[0]->amount,2) }}
                        </div>
                      </div>
                    </td>
                </tr> 

                <tr>
                   <td  style="border-right:none">
                      <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                          <!-- <div class="" style="font-size:larger">
                            Next Month's Payout
                          </div> -->

                          <div class="" style="font-size:larger">
                            Next Month's Payout
                          </div>
                          <div>
                            <form>
                                <div class="form-group">
                                <label for="exampleFormControlSelect1">Payout or Deferred:</label>
                                  <div id="updatedeferred2app">
                                     <custom-editdeferred2 isdeferred="{{ $payouts[1]->isDeferred }}" uid="{{ $user->id }}"></custom-editdeferred2>
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
                         $&nbsp{{ number_format($payouts[1]->amount,2) }}
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
                         
             
                             $residual = $running_balance - $transaction->amount;
                             
                             $running_balance = $residual;
                             $run_bal_orig = $running_balance + $transaction->amount;
                          @endphp

                         <div>$&nbsp{{ number_format($run_bal_orig,2) }}</div>
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

        @endif

        <br>
        <br>
        @if (Auth::user()->id == 1)
          <section class="jumbotron text-center">
          Second Table
          <table id="example2" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Bitcoin Address</th>
                    <th>This Month</th>
                    <th>Next Month</th>
                   
                    <th>Add Transaction</th>
                    <th>View Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                  @if ($user->id <3)
                  @else
                    <tr>
                        <td>{{ $user->id -2 }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->bitcoin_address }}</td>
                        <td>{{ $user->isDeferred1 }}</td>
                        <td>{{ $user->isDeferred2 }}</td>
                       
                        <td><a data-toggle="modal" data-target="#exampleModal{{ $user->id }}" data-id="{{ $user->id }}" href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a></td>
                        <td><a href="{{ route('get_user_transactions',$user->id) }}" target="blank" class="btn btn-primary"><i class="fas fa-binoculars"></i></a></td>
                        <td><a href="{{ route('payouts',$user->id) }}" target="blank" class="btn btn-primary"><i class="fas fa-binoculars"></i></a></td>
                        <!-- :href="/getusertransactions/+item.id" target="_blank" -->
                    </tr>
                  @endif
                @endforeach 
             </tbody>
            <tfoot>
                <tr>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    
                </tr>
            </tfoot>
        </table>
          </section>


          <!-- Modal  

         

          -->

  


<div  class="modal fade" id="exampleModalBBB2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Transaction Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
                    <div class="card">
                         
                        <div class="card-body">

                            <div class="form-group">
                               <!--  <label for="transaction_input">Enter Id Of User:</label> -->
                                <input type="hidden" id="id" name="id" class="form-control" readonly> 
                            </div>

                            <div class="form-group">
                                <label for="transaction_input">Enter Date: <!--  <span class="text-muted">(format:year-month-day / 2022-03-10 ) </span> --> </label>

                                <!-- <input  type="input"   name="transaction_input" class="form-control" v-model="ldate2"  >--> 
                                <div class="container-fluid" id="modaldatepickerapp2">
                                      <Datepicker v-model="ldate2" :format="format"></Datepicker>
                                </div>

                              
                            </div>

                            <div class="form-group">
                                <label for="amount_input">Enter Amount:</label>
                                
                                <input type="input" name="amount_input" class="form-control" v-model="lamount"  > 

                            </div>
                    
                         
                            <div class="form-group">
                                  <label for="type_select">Select Type</label>
                            <select class="form-control" id="type_select" v-model="ltype">
                              <option value="1">Deposit</option>
                              <option value="3">Deferred</option>
                              <option value="4">Withdraw</option>
                              <option value="5">Bonus</option>
 
                            </select>
                            </div>

                            <div class="form-group">
                                    <a @click="submit_transactions" href="#" class="d-block btn btn-primary">Upload</a> 
                            </div>
                        </div>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div id="modaldatepickerapp" >
  @foreach ($users as $user)
                  @if ($user->id <3)
                  @else

<div  class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
 

    <div class="modal-content"   >
     <!--  <h1>hello world</h1> -->
      <customform id="testform" u_id="{{ $user->id }}" d_id="{{ $user->id }}"></customform>
  <!--     <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Transaction Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="container-fluid" >
                                      <Datepicker id="datepicker" v-model="ldate2" :format="format"></Datepicker>
                                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
      <input type="hidden" id="testing">
  </div>
</div>
                  @endif
                @endforeach 
</div>
        @endif

        @if (Auth::user()->admin == 1)
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
     
    </div>

    


    </form>
  </section>
    @endif
  <br>
  <br>
  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

  <script src="https://unpkg.com/vue@next"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    $(document).ready(function() {
       $('#searchtable').DataTable({
        "order": [],
         "ordering": false 
      });

      $('#example2').DataTable({
        stateSave: true
      });

        initDataTables(); 
    } );

  

  </script>

  <script type="text/javascript">

    if (document.querySelector('#showDepositApp')) {

        const showDepositApp = Vue.createApp({
        delimiters: ['${','}'],
        data() {
         return {
            
         }
        },
        })



        showDepositApp.component('custom-showdeposit', {
      delimiters: ['${','}'],
      created() {
               
      },
      props: ['baddress','uid'],
      methods: {
        loaddata2(event) {
                  Swal.fire({
                  title: 'OmniPool (Beta)<BR> Below is the Address to Send the Bitcoin',
                  html:
    'bc1q6edg5tjtpydzun8zcug4jg9psvmuz6qn7cf0ec<br><br><img src="{{ asset('image/btc_qr.png') }}" alt=""> <br><br>IMPORTANT: Please copy it CAREFULLY <br><br> Make sure the beginning and ending of the address are copied.',
                  //icon: 'warning',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ok'
                }).then((result) => {
                  if (result.isConfirmed) {

                    axios.post('/deletetransactions',{
                
                        trans_id: this.ltrans_id
                      
                      }) 
                     .then(results => {

                         this.$swal(
                          'Done!',
                          'The transaction has been deleted. Please click View Account again',
                          'success'
                        )
                        
                         console.log(results)
          
                     })


                   
                  }
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
       <li class="nav-item">
        <a @click="loaddata2" class="btn btn-sm btn-primary" >
           Deposit
        </a>
      </li>
      `
    }) 

    showDepositApp.mount('#showDepositApp')


    }
    
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