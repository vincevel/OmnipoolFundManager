
@extends('layouts.adminmaster')

@section('header1')
<h1 class="m-0">Admin Dashboard</h1>
@endsection

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
 
   

        <br>
        <br>
        <!-- <div><a href="#"><img alt="widget" src="https://widgets.myfxbook.com/widgets/9527274/large.jpg"/></a></div>
        <div><a href="#"><img alt="widget" src="https://widgets.myfxbook.com/widgets/9527302/large.jpg"/></a> 
</div>-->

        @if (Auth::user()->admin == 1)
          <section class="jumbotron text-center container-fluid">
          <div class="container-fluid">
          <table id="example2" class="table table-striped table-bordered table-responsive" style="">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Btc</th>
                    <th>Balance</th>
                    <th>NextTier</th>
                    <th>Disperse</th>
                    <th>Defers</th>
                    <th>This Month</th>
                    <th>Interest Rate</th>
                    <th>Action</th>
                    <!-- <th>View Details</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                  @if ($user->id <3)
                  @else
                    <tr>
                        <td>
                          
                            {{ $user->id-2 }}
                          
                          
                        </td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <!-- <td>{{ $user->bitcoin_address }}</td> -->
                        @if (trim($user->bitcoin_address!=NULL))
                        
                          @if (strlen(trim($user->bitcoin_address))>11)
			  <td>
<!-- <a class="btn btn-danger" data-toggle="popover" title="Bitcoin Address" data-placement="top" data-content="{{ $user->bitcoin_address }}"><i class="fas fa-light fa-bitcoin-sign"></i></a> -->
<a tabindex="0" class="btn btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Bitcoin Address" data-content="{{ $user->bitcoin_address }}"  onclick="myFunction('a{{ $user->id }}')">
<i class="fas fa-light fa-bitcoin-sign"></i></a>
<input type="hidden" id="a{{ $user->id }}" value="{{ $user->bitcoin_address }}">

</td>
                          @else 
			  <td>
<!-- <a class="btn btn-secondary" data-toggle="popover" title="Bitcoin Address" data-placement="top" data-content="{{ $user->bitcoin_address }}"><i class="fas fa-light fa-bitcoin-sign"></i></a> -->
<a tabindex="0" class="btn btn-secondary" role="button" data-toggle="popover" data-trigger="focus" title="Bitcoin Address" data-content="{{ $user->bitcoin_address }}"   ><i class="fas fa-light fa-bitcoin-sign"></i></a>
<!-- <input type="hidden" id="b{{ $user->id }}" value="{{ $user->bitcoin_address }}"> -->
</td>
</td>
                          @endif


                        @else
                        <td></td>
                        @endif
                        <td>{{ number_format($user->total_balance,2,'.',',') }}</td>  
                        <td>@if($user->total_balance>0){{number_format($user->amount_to_next_tier,2,'.',',') }}@else{{0}}@endif</td>  
                       <!--  <td>
                          <button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Bitcoin Addres" data-placement="top" data-content="{{ $user->bitcoin_address }}">B</button>
                        </td> -->
                        <td>@if($user->isDeferred1==1)0 @else $&nbsp{{number_format($user->curr_payout,2,'.',',')}} @endif</td> 
                        <td>@if($user->isDeferred1==1)$&nbsp{{number_format($user->curr_payout,2,'.',',')}} @else 0 @endif</td> 

                        @if ($user->isDeferred1  == 1)
                        <td>D</td>
                        @else
                        <td>P</td>
                        @endif
                        
                       <td>{{$user->interest_rate}}%</td>
                        <td>
                          <div class="d-flex flex-column flex-lg-row justify-content-between" style="width: 150px;" >
                            <div>
                              <a data-toggle="modal" data-target="#interestRateModal{{ $user->id }}" data-user-id="{{ $user->id}}" data-verified="{{ $user->verified}}" data-interest="{{ $user->interest_rate}}" href="#" class="btn btn-primary"><i class="fas fa-percent"></i></a>
                            </div>
                            <div>
                              <a data-toggle="modal" data-target="#exampleModal{{ $user->id }}" data-id="{{ $user->id}}" href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                            </div>
                            <div>
                              <a href="{{ route('payout_monthly_admin',$user->user_id) }}" target="_blank" class="btn btn-primary"><i class="fa-solid fa-money-check-dollar"></i></a>
                            </div>
                            <div class=" ">  
                              <a href="{{ route('get_user_transactions',$user->id) }}" target="_blank" class="btn btn-primary"><i class="fas fa-binoculars"></i></a>
                            </div>
                            
                          </div>
                        </td>
                        <!-- <td></td> -->
                        <!-- :href="/getusertransactions/+item.id" target="_blank" -->
                    </tr>
                  @endif
                @endforeach 
             </tbody>
            <tfoot>
                <tr>
                    <th>Grand Total</th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                    <th>{{ number_format($grand_total_balance,2) }}</th>
                    <th>{{ number_format($grand_total_to_next_tier,2) }}</th>
                    <th>{{ number_format($grand_total_payouts,2)  }}</th>
                    <th>{{ number_format($grand_total_defers,2)  }}</th>
                    <th>{{ number_format($grand_total_defers + $grand_total_payouts,2)  }}</th>
                    <th> </th>
                    <th> </th>
                    <!-- <th> </th> -->
                    
                </tr>
            </tfoot>
        </table>
        </div>
          </section>


          <!-- Modal  

         

          -->

  
          <div id="modalchangeinterestrate" >
            
            @foreach ($users as $user)
              
              @if ($user->id <3)
              @else
          
                <div  class="modal fade" id="interestRateModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="interestRateModalLabel" aria-hidden="true" >
                  <div class="modal-dialog" role="document">
                
                
                    <div class="modal-content"   >
                    <!--  <h1>hello world</h1> -->
                      <changeinterestrate id="formtest" user_id="{{ $user->id }}" interest="{{ $user->interest_rate  }}" verified="{{ $user->verified  }}"></changeinterestrate>
                  
                    </div>
                      <input type="hidden" id="testing">
                  </div>
                </div>
          
              @endif
            @endforeach 
          </div>

<div id="modaldatepickerapp" >
  @foreach ($users as $user)
                  @if ($user->id <3)
                  @else

<div  class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
 

    <div class="modal-content"   >
     <!--  <h1>hello world</h1> -->
      <customform id="testform" u_id="{{ $user->id }}" d_id="{{ $user->id  }}"></customform>
   
    </div>
      <input type="hidden" id="testing">
  </div>
</div>
                  @endif
                @endforeach 
</div>

        @endif

      
  <br>
  <br>




    @if (Auth::user()->admin == 1234)
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



 

  <script src="https://unpkg.com/vue@next"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js" integrity="sha512-lTLt+W7MrmDfKam+r3D2LURu0F47a3QaW5nF0c6Hl0JDZ57ruei+ovbg7BrZ+0bjVJ5YgzsAWE+RreERbpPE1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!--  <script src="https://unpkg.com/vue@3.0.5/dist/vue.global.prod.js"></script> -->
  
  <script type="text/javascript">
    
   $('.sidebar-toggle-btn').click(function() {
    //alert( "Handler for .click() called." );
    $('#adminlabel').toggle();
    $('.customicon').toggle();
   // alert("here");
  });

    </script>
 



    <script>

    //for popovers
    $(function () {
      $('[data-toggle="popover"]').popover(
           

      )


    })


    $(document).ready(function() {
     

      $('#example2').DataTable({
        stateSave: true,
        "pageLength": 50,
      });

        initDataTables(); 
    } );

  

  </script>
 
<script>
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
</script>
<script>
  function myFunction2() {
    alert("Here");
  }

  function myFunction(id) {
  //  alert(id)
  /* Get the text field */
  var copyText = document.getElementById(id);

  /* Select the text field */
  //copyText.select();
  //copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */
  //navigator.clipboard.writeText(copyText.value);
  copyToClipboard(copyText.value);
  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}

function copyToClipboard(text) {
    var sampleTextarea = document.createElement("textarea");
    document.body.appendChild(sampleTextarea);
    sampleTextarea.value = text; //save main text in it
    sampleTextarea.select(); //select textarea contenrs
    document.execCommand("copy");
    document.body.removeChild(sampleTextarea);
}

function myFunction3(){
    var copyText = document.getElementById("myInput");
    copyToClipboard(copyText.value);
}
</script>

@endsection
