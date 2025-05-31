<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Verification Org</title>
   <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />

    <style>
        .orange {
            background-color: #fa7d09;
        }
        
        .gray {
            background-color: gray;
        }

        .opac {
            opacity: 1;
            border-radius: 5px !important;
        }
        
    </style> 
</head>

<body>
 

   @if(session()->has('message'))
                    
                     <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                   
                  @endif    
<div class="container-fluid">
    <div class="row">
        <form id="" action="{{ route('verification.filterpending') }}" method="get">
         {{ csrf_field() }}
        <div class="col">
            <h1 class="mt-3 ml-3">Verification Org</h1>
             <button class="btn btn-warning" type="submit">Filter To Show Pending</button>
             <p></p>
             <input id="pendingFlag" name="pendingFlag" type="hidden" value="1">
        </div>
    
			 
			   
			   
	    </form>
    </div>
    <!-- Search form -->
     <form id="" action="{{ route('verification.search') }}" method="get">
			 
			    {{ csrf_field() }}
			    
    <div class="row">
            
        
              <div class="input-group mb-3 ml-2 mr-2">
          <input type="text" name="search" class="form-control" placeholder="Search By First Name, Last Name or Email" aria-label="Recipient's username" aria-describedby="basic-addon2">
          <div class="input-group-append">
            
             @isset($search)  
                @if ($search)
                 <button class="opac btn btn-outline-danger mr-2" style="margin-left: -140px; z-index: 100;">Clear Search  <i class="fa fa-times"></i>
                </button>
                @endif
             @endisset()  
              
                
            <button class="btn btn-primary" type="submit">Search</button>
          </div>
          
        </div>
    </div>
    </form>
    
    <div class="row">
        <div class="col">
   @isset($transactions)  
        @if (count($transactions) > 0)
       
              <table class="table table-sm">
              <thead>
               
                <tr>
      
                    <th>id</th> 
                    <th>date_transaction</th> 
                    <th>name</th>
                    <th>email</th>  
                    
                    <th>dividend_payout</th>  
                    <th>contribution_payout</th>  
                    
                    <th>amount</th> 
                    <th>sri_balance</th> 
                    <th>investment</th>  
                    <th>status</th> 
                    <th>remarks</th> 
                    <th>View</th>
                    <th>Parent Id</th>
          
                  
                </tr>
              </thead>
              <tbody>
                
   
            @foreach ($transactions as $t2)

            @if ($t2->transaction_type_id != 6)          
            <tr class="gray">
            @else
            <tr>
            @endif
                <td> {{ $t2->orig_id }} </td> 
                <td> {{ trim($t2->date_transaction) }} </td> 
                <td> {{ ucwords(strtolower($t2->first_name)) }} {{ ucwords(strtolower($t2->last_name)) }} </td>
       
                
                
                
                <td><a href="{{ route('verification.userverify',$t2->user_id) }}"> {{ $t2->email }} </a></td>
                
                @if ($t2->dividend_payout == "0.00")
                <td> - </td>
                
                @elseif ($t2->dividend_payout)
                <td> {{ $t2->dividend_payout }} </td>
                @else
                <td> - </td>
                @endif
                
                @if ($t2->dividend_payout == 0.00)
                <td> - </td>
                @elseif ($t2->contribution_payout)
                <td> {{ $t2->contribution_payout }} </td>
                @else
                <td> - </td>
                @endif
                
                    @if ($t2->amount % 10000)

                        @if ($t2->transaction_type_id != 6)                     
                            <td class="bg-warning"> {{ $t2->amount }}  </td> 
                        @else
                            <td> {{ $t2->amount }}  </td> 
                        
                        @endif
                        
                        
                    @else
                    <td> {{ $t2->amount }}  </td> 
                    @endif 
                <td> {{ $t2->sri_balance }} </td>  
                <td> {{ $t2->investment_type }} </td>  
                
                @if ($t2->status == "Verified")
                    <td><strong class="text-success">{{ $t2->status }}</strong></td> 
                @elseif ($t2->status == "Deleted")
                    <td><strong class="text-danger">{{ $t2->status }}</strong></td> 
                @elseif ($t2->status == "Pending")
                    <td><strong class="text-primary">{{ $t2->status }}</strong></td> 
                @else
                    <td><strong class="orange">{{ $t2->status }}</strong></td> 
                @endif 
                 
                <td> {{ $t2->remarks }} </td> 
                <td> <input value="{{ $t2->parent_id }}"></td> 
                <td> 
                    
                <a class="btn-sm btn-primary" href="{{ route('showuser',$t2->user_id) }}" target="_blank"><i class="fas fa-binoculars"></i></a></td> 
               
                
               
            </tr>
          
            @endforeach

        @endif
  @endisset
    
    
    </tbody>
    </table>
    <table class="table table-sm">
        <tr>
         <td>  {{$transactions->links("pagination::bootstrap-4")}}</td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
    </tr>  
    <tr>
        
        <td>
            <a href="/sri/backend" class="form-submit-button" data-component="button" data-content="">Back</a> 
        </td>
        <td>   </td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
     </tr>
    </table>

  @if (count($transactions) > 0)
    
        
        
         
        
            </div> <!-- end col -->
        </div>   <!-- end row -->           
    </div> <!-- end container -->              
  
    <!-- MODALS -->
	 
	
	
	<!-- To del MODAL -->
	
	<div class="modal fade" id="deletePendingModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <form id="deletePendingForm" action="{{ route('verification.delete',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Delete Entry</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				  
    				
    				
    						<div class="form-group">
    							<label for="">Date Transaction</label>
    							<input id="deleteDate" name="deleteDate" type="text" class="form-control">
    							<input id="deleteId" name="deleteId" type="hidden" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Name</label>
    							<input id="deleteName" name="deleteName" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Email</label>
    							<input id="deleteEmail" name="deleteEmail" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Amount</label>
    							<input id="deleteAmount" name="deleteAmount" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Status</label>
    							<input id="deleteStatus" name="deleteStatus" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Investment</label>
    							<input id="deleteInvestment" name="deleteInvestment" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Remarks</label>
    							<input id="deleteRemarks" name="deleteRemarks" type="text" class="form-control">
    						</div>
    						
    						
    						<!--
    						<div class="form-group">
    						    <button type="submit" class="btn btn-primary mr-auto" >Save</button>
    						</div>    
    					    -->
    				</div>
    				<!-- End modal body -->
                 
    				<div class="modal-footer">
    					<div class="form-group">
        					<button type="submit" class="btn btn-primary" data-dismiss="modal" >Cancel</button>
        					<button type="submit" class="ml-auto btn btn-danger mr-auto" >Confirm Delete</button>
    					</div>
    				</div>
    				
    				</form>
    				<!-- End modal footer -->
				
			</div>
		</div>
	</div>
	<!-- End To del MODAL -->
	
	
		<!-- To verify MODAL -->
	
	<div class="modal fade" id="verifyModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <form id="verifyForm" action="{{ route('verification.verify',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Verify Entry</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				
    						<div class="form-group">
    						    
    						    <input id="verifyId" name="verifyId" type="hidden" class="form-control">
    							<label for="">Date Transaction</label>
    							<input id="verifyDate" name="verifyDate" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Name</label>
    							<input id="verifyName" name="verifyName" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Email</label>
    							<input id="verifyEmail" name="verifyEmail" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Amount</label>
    							<input id="verifyAmount" name="verifyAmount" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Status</label>
    							<input id="verifyStatus" name="verifyStatus" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Investment</label>
    							<input id="verifyInvestment" name="verifyInvestment" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Remarks</label>
    							<input id="verifyRemarks" name="verifyRemarks" type="text" class="form-control">
    						</div>
    						
    						
    						<!--
    						<div class="form-group">
    						    <button type="submit" class="btn btn-primary mr-auto" >Save</button>
    						</div>    
    					    -->
    				</div>
    				<!-- End modal body -->
                 
    				<div class="modal-footer">
    					<div class="form-group">
        					<button type="submit" class="btn btn-primary" data-dismiss="modal" >Cancel</button>
        					<button type="submit" class="ml-auto btn btn-success mr-auto" >Confirm Verify</button>
    					</div>
    				</div>
    				
    				</form>
    				<!-- End modal footer -->
				
			</div>
		</div>
	</div>
	<!-- End To verify MODAL -->
	
		<!-- To pending MODAL -->
	
	<div class="modal fade" id="pendingModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <form id="pendingForm" action="{{ route('verification.pending',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Set to Pending</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				
    						<div class="form-group">
    						    
    						    <input id="pendingId" name="pendingId" type="hidden" class="form-control">
    							<label for="">Date Transaction</label>
    							<input id="pendingDate" name="pendingDate" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Name</label>
    							<input id="pendingName" name="pendingName" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Email</label>
    							<input id="pendingEmail" name="pendingEmail" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Amount</label>
    							<input id="pendingAmount" name="pendingAmount" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Status</label>
    							<input id="pendingStatus" name="pendingStatus" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Investment</label>
    							<input id="pendingInvestment" name="pendingInvestment" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    							<label for="">Remarks</label>
    							<input id="pendingRemarks" name="pendingRemarks" type="text" class="form-control">
    						</div>
    						
    						
    						<!--
    						<div class="form-group">
    						    <button type="submit" class="btn btn-primary mr-auto" >Save</button>
    						</div>    
    					    -->
    				</div>
    				<!-- End modal body -->
                 
    				<div class="modal-footer">
    					<div class="form-group">
        					<button type="submit" class="btn btn-primary" data-dismiss="modal" >Cancel</button>
        					<button type="submit" class="ml-auto btn btn-warning mr-auto" >Confirm Pending</button>
    					</div>
    				</div>
    				
    				</form>
    				<!-- End modal footer -->
				
			</div>
		</div>
	</div>
	<!-- End To pending MODAL -->
	
	
	<!-- END MODALS -->
        @endif    
  
  
  
 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous"></script>

<script>
    
 
   
    $('#addPendingModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id1 = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      
      //modal.find('.modal-title').text('New message to ' + recipient)
      //modal.find('.modal-body input').val(recipient)
      //modal.find('.modal-title').text('New message to ' + recipient)

      //set input value
      modal.find('.modal-body #itemId').val(id1)
      //set form value
      //modal.find('.modal-body #addPendingForm').attr('action', 'https://www.vincerapisura.com/sri/staging/transfer/' + id1)
      
 
    })
    
     $('#deletePendingModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //var id = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
     
      modal.find('.modal-body #deleteId').val(button.data('id'))
      modal.find('.modal-body #deleteDate').val(button.data('datetransaction'))   
      modal.find('.modal-body #deleteName').val(button.data('requestedby')) 
      modal.find('.modal-body #deleteEmail').val(button.data('email')) 
      modal.find('.modal-body #deleteAmount').val(button.data('amount')) 
      modal.find('.modal-body #deleteStatus').val(button.data('status')) 
      modal.find('.modal-body #deleteInvestment').val(button.data('investment')) 
      modal.find('.modal-body #deleteRemarks').val(button.data('remarks')) 
    })
    
     $('#verifyModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //var id = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
     
        modal.find('.modal-body #verifyId').val(button.data('id'))
        modal.find('.modal-body #verifyDate').val(button.data('datetransaction'))   
        modal.find('.modal-body #verifyName').val(button.data('requestedby')) 
        modal.find('.modal-body #verifyEmail').val(button.data('email')) 
        modal.find('.modal-body #verifyAmount').val(button.data('amount')) 
        modal.find('.modal-body #verifyStatus').val(button.data('status')) 
        modal.find('.modal-body #verifyInvestment').val(button.data('investment')) 
        modal.find('.modal-body #verifyRemarks').val(button.data('remarks')) 
    })

     $('#pendingModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //var id = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
     
        modal.find('.modal-body #pendingId').val(button.data('id'))
        modal.find('.modal-body #pendingDate').val(button.data('datetransaction'))   
        modal.find('.modal-body #pendingName').val(button.data('requestedby')) 
        modal.find('.modal-body #pendingEmail').val(button.data('email')) 
        modal.find('.modal-body #pendingAmount').val(button.data('amount')) 
        modal.find('.modal-body #pendingStatus').val(button.data('status')) 
        modal.find('.modal-body #pendingInvestment').val(button.data('investment')) 
        modal.find('.modal-body #pendingRemarks').val(button.data('remarks')) 
    })
    
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });

</script>


 <!-- 
                    <th> running_balance  </th> 
                    <th> notes  </th> 
                    <th> notes_investment_purpose  </th> 
                    <th> transaction_id  </th>  
                    <th> transaction_type_id  </th>  
                    <th> file_name  </th> 
                    <th> notes_withdraw_reason  </th>
                    <th> bank_name  </th>
                    <th> bank_acct_no  </th>
                    <th> bank_acct_name  </th>
                    <th> bank_branch  </th>  
                    <th> bank_account_type  </th> 
                    <th> bankrouting_no  </th> 
                    <th> govt_id  </th>  
                    <th> authorization_letter  </th>
                    <th> first_name  </th>  
                    <th> last_name  </th>
                    <th> account_name  </th>  
                    <th> account_id  </th> 
                    <th> is_posted  </th> 
                    <th> testing  </th> 
                    <th> seen  </th>  
                    <th> dividend_payout  </th>
                    <th> contribution_payout  </th>
                    <th> sent_certificate  </th> 
                    -->
                <!-- 
                
                <td> {{ $t2->running_balance }} </td> 
                <td> {{ $t2->notes }} </td> 
                <td> {{ $t2->notes_investment_purpose }} </td> 
                <td> {{ $t2->transaction_id }} </td> 
                <td> {{ $t2->transaction_type_id }} </td> 
                <td> {{ $t2->file_name }} </td> 
                <td> {{ $t2->notes_withdraw_reason }} </td>
                <td> {{ $t2->bank_name }} </td>
                <td> {{ $t2->bank_acct_no }} </td>
                <td> {{ $t2->bank_acct_name }} </td>
                <td> {{ $t2->bank_branch }} </td>  
                <td> {{ $t2->bank_account_type }} </td> 
                <td> {{ $t2->bankrouting_no }} </td> 
                <td> {{ $t2->govt_id }} </td>  
                <td> {{ $t2->authorization_letter }} </td>
                <td> {{ $t2->first_name }} </td>  
                <td> {{ $t2->last_name }} </td>
                <td> {{ $t2->account_name }} </td>  
                <td> {{ $t2->account_id }} </td> 
                <td> {{ $t2->is_posted }} </td> 
                <td> {{ $t2->testing }} </td> 
                <td> {{ $t2->seen }} </td>  
                
                
                <td> {{ $t2->dividend_payout }} </td>
                <td> {{ $t2->contribution_payout }} </td>
                <td> {{ $t2->sent_certificate }} </td> 
                 -->


 </body>

</html>
