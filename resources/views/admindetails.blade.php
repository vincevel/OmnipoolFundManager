
@extends('layouts.adminmaster')
@section('content')
<style>
 


</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Dashboard</div>

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
 
   

        <!-- <br>
        <br> -->
        @if (Auth::user()->admin == 1235321)
          <section class="jumbotron text-center">
         
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
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        
                        @if (trim($user->bitcoin_address!=NULL))
                        <td>{{ $user->bitcoin_address }}</td>
                        @else
                        <td></td>
                        @endif

                        @if ($user->isDeferred1  == 1)
                        <td>D</td>
                        @else
                        <td>P</td>
                        @endif
                        @if ($user->isDeferred2  == 1)
                        <td>D</td>
                        @else
                        <td>P</td>
                        @endif

                        <td><a data-toggle="modal" data-target="#exampleModal{{ $user->id }}" data-id="{{ $user->id}}" href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a></td>
                        <td><a href="{{ route('get_user_transactions',$user->id) }}" class="btn btn-primary"><i class="fas fa-binoculars"></i></a></td>
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

  
 

<div id="modaldatepickerapp" >
  @foreach ($users as $user)
                  @if ($user->id <3)
                  @else

<div  class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
 

    <div class="modal-content"   >
     <!--  <h1>hello world</h1> -->
    <!--   <customform id="testform" u_id="{{ $user->id }}" d_id="{{ $user->id - 2 }}"></customform> -->
   
    </div>
      <input type="hidden" id="testing">
  </div>
</div>
                  @endif
                @endforeach 
</div>
        @endif

      
<!--   <br>
  <br> -->


   @if (Auth::user()->admin != 5125)
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

   @if (Auth::user()->admin == 1)


   <h2 class="pt-2  ">{{ ucwords($user->last_name) }}, {{ ucwords($user->first_name) }}</h2>   <h5>ID# {{ $user->id - 2 }}</h5>
    <div class="row justify-content-end pb-3">
     
      <div class="col-md-3">
        <a data-toggle="modal" data-target="#exampleModals{{ $user->id }}" data-id="{{ $user->id}}" href="#" class="btn btn-info btn-sm d-block">Add Transaction</a>
        
      </div>
      <div class="col-md-3"><a href="{{ route('payout_monthly_admin',$user->id) }}" target="_blank" class="btn btn-info btn-sm d-block">Payouts</a></div>
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
                           Total Paid Out
                         </div>
                       </div>
                     </div>
                  </td>
                   <td >
                     <div class="d-flex flex-column">
                       <div class="text-right" style="font-size:larger">
                        $&nbsp{{ number_format($total_payouts,2) }}
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
                          @if($total_balance>0)
                            $&nbsp{{ number_format($amount_to_next_tier,2) }}
                          @else
                            0
                          @endif
                        </div>
                      </div>
                    </td>
                </tr> 

   

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
                                  @if(count($payouts)>0)<custom-editdeferred1 isdeferred="{{ $payouts[0]->isDeferred }}" uid="{{ $payouts[0]->user_id }}" ></custom-editdeferred1>@endif
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
                          @if(count($payouts)>0)$&nbsp{{ number_format($payouts[0]->amount,2) }}@endif
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
                                    @if(count($payouts)>0) <custom-editdeferred2 isdeferred="{{ $payouts[1]->isDeferred  }}" uid="{{ $payouts[1]->user_id }}"></custom-editdeferred2>@endif
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
                          @if(count($payouts)>0)$&nbsp{{ number_format($payouts[1]->amount,2) }}@endif
                        </div>
                      </div>
                    </td>
                </tr> 
           
          </tbody>
        </table> 
        <br>
        <br>
        
 <table style="1px solid black; width:100%" class="table table-bordered" id="deleteapp">
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

                  //$dateForPicker = $day . "/" . $month . "/" . $year; 

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
                            
                            @elseif ($transaction->transaction_type_id == 7)
                              Dispersed
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
                         
                             
                          @endphp

                         <div>$&nbsp{{ number_format($transaction->running_balance,2) }}</div>
                        
                         @php
                  
                          @endphp

                        </div>
                        <div class="text-right">
                         <!-- <i class="fas fa-pen-to-square"></i> -->
                          <deletecomponent trans_id="{{ $transaction->id }}"></deletecomponent>
                          <!-- <editcomponent trans_id="{{ $transaction->id }}"></editcomponent> -->
                          <div>
                              <a data-toggle="modal" data-target="#exampleModal{{ $transaction->id }}" data-id="{{ $transaction->id }}" href="#" class=" "><i class="fas fa-pen-to-square"></i></a>

                            </div>
                         </div>
                             <!--  <div class="text-right">
                         <i class="fas fa-trash"></i>
                          
                         </div> -->
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

    @if (Auth::user()->admin == 1243)
  <div  >
    <div class="card card-primary card-outline ">
    <div class="card-header">
    <h5 class="m-0">Upload Transactions</h5>
    </div> <!-- header -->
    <div class="card-body">
    <!-- <p>format:date_transaction,user_id,amount,transaction_type</p> -->
    <!-- <p>example:2021-12-22,86,10000,1</p>
    <p>date format:year-month-day</p> -->
    <!-- <p>*no commas for amount</p>
    <p>transaction type - 1 for deposit, 3 for deferred</p> -->
    <!-- <h6 class="card-title">Special title treatment</h6> -->
    <!-- <p class="card-text">Upload Transactions Here</p> -->
    <div id="app" class="pt-4"></div>
    
    </div> <!-- body -->
    </div> <!-- card -->
  </div>
  @endif

  <div id="editmodaldatepickerapp" >
      @foreach ($transactions as $transaction)


    <div class="modal fade" id="exampleModal{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
      <div class="modal-dialog" role="document">
     

        <div class="modal-content"   >
          <!-- <h1>Test Edit Field</h1> -->
          <customeditform id="testeditform" transaction_id="{{ $transaction->id }}" amount="{{ $transaction->amount }}" transaction_type="{{ $transaction->transaction_type_id }}" input_date="{{ $transaction->date_transaction }}" image="{{ $transaction->image }}" ></customeditform>
  
        </div>
          <input type="hidden" id="testing">
      </div>
    </div>
                     
                    @endforeach 
    </div>
    <div id="modaldatepickerapp" >
     
    
    <div  class="modal fade" id="exampleModals{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
      <div class="modal-dialog" role="document">
     
    
        <div class="modal-content"   >
         <!--  <h1>hello world</h1> -->
          <customform id="testform" u_id="{{ $user->id }}" d_id="{{ $user->id  }}"></customform>
       
        </div>
          <input type="hidden" id="testing">
      </div>
    </div>
    </div>



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
    $(document).ready(function() {
     

      $('#example2').DataTable({
        stateSave: true
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
            console.log(this)   
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
            this.blabel = "UPDATED"
            this.updated = true
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
          blabel: "Update",
          updated: false
        }
      },
      template: `   
        <div class="form-group">
          <label for="bitcoin_address">Set Your Bitcoin Address:</label>
          <input class="form-control" type="text" v-model="lbaddress" name="bitcoin_address" id="bitcoin_address" />
        </div>
        <div class="form-group">
          <a href="#" :class="{ 'btn-success': updated }" class="btn btn-primary d-block"  @click="loaddata2">$\{ this.blabel \}</a>
          
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


@endsection