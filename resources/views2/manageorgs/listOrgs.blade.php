<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Manage SRI Orgs</title>
   <script src="https://kit.fontawesome.com/7478e5c9f8.js" crossorigin="anonymous"></script>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />

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
            <h1 class="mt-3 ml-3">Manage SRI Orgs</h1>
            <!--
             <button class="btn btn-warning" type="submit">Filter To Show Pending</button>
             -->
             <p></p>
             <input id="pendingFlag" name="pendingFlag" type="hidden" value="1">
        </div>
    
			 
			   
			   
	    </form>
    </div>
    <!-- Search form -->
     <form id="" action="" method="get">
			 
			    {{ csrf_field() }}
			    
    <div class="row">
            
        
              <div class="input-group mb-3 ml-2 mr-2">
          <input type="text" name="search" class="form-control" placeholder="Search By Code or Title" aria-label="Recipient's username" aria-describedby="basic-addon2">
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
   @isset($orgs)  
        @if (count($orgs) > 0)
       
              <table class="table table-sm">
              <thead>
               
                <tr>
      
                    <th>SN</th> 
                    <th>Code</th>
                    <th>Title</th>  
                    <th>Denomination</th> 
                    <th>Max Deposit Amt</th> 
                    <th>Type</th>  
                    <th>Full</th>  
                    <th>Term Length in Months</th>  
                    <th>Payout Freq</th> 
                    <th>Limit</th> 
                    <th>Enabled</th>
                    <th>Remarks</th> 
                 
                    <th>Add</th>
                    <th>Edit</th>
                    <th>Delete </th>
                  
                </tr>
              </thead>
              <tbody>
                
   
            @foreach ($orgs as $t2)
            <tr>
                <td> {{ trim($t2->id) }} </td> 
                <td> {{ trim($t2->code) }} </td> 
                <td> {{ trim($t2->title) }} </td> 
                <td class="text-right"> {{ number_format(trim($t2->denomination), 2, '.', ',') }} </td> 
                <td class="text-right"> {{ number_format(trim($t2->maxdepositamt), 2, '.', ',') }} </td> 
                <td class="text-right"> {{ trim($t2->type) }} </td>
                <td> @if (trim($t2->full) > 0) {{ 
                    "Yes"
                }} 
                    @else {{
                    
                    "No"
                    }}
                    
                    @endif
                </td>
                 <td class="text-right"> {{ trim($t2->termlength) }} </td>
                <td class="text-right"> {{ trim($t2->payoutfrequency) }} </td>
                <td class="text-right"> {{ number_format(trim($t2->maxamount), 2, '.', ',') }} </td>
               
                <td> @if (trim($t2->enabled) > 0) {{ 
                    "Yes"
                }} 
                    @else {{
                    
                    "No"
                    }}
                    
                    @endif
                </td>
                <!--
                   <th>View</th>
                <td> {{ ucwords(strtolower($t2->first_name)) }} {{ ucwords(strtolower($t2->last_name)) }} </td>
       
                
                
                
                <td> {{ $t2->email }} </td>  
                
                <td> {{ $t2->amount }} <a href="{{ $t2->file_name }}" data-toggle="lightbox"><i class="far fa-file-alt"></i></a> </td> 
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
                
                  <a class="btn-sm btn-primary" href="{{ route('showuser',$t2->user_id) }}" target="_blank"><i class="fas fa-binoculars"></i></a></td> 
                <td>
                    <button class="btn-sm btn-success "   data-toggle="modal" data-target="#verifyModal"
                    data-id="{{ $t2->id }}"
                    data-datetransaction="{{ $t2->date_transaction }}"
                    data-requestedby="{{ ucwords(strtolower($t2->first_name)) }} {{ ucwords(strtolower($t2->last_name)) }}"
                    data-email="{{ $t2->email }}"
                    data-amount="{{ $t2->amount }}"
                    data-status="{{ $t2->status }}"
                    data-investment="{{ $t2->investment_type }}"
                    data-remarks="{{ $t2->remarks }}"
                    >
                                <i class="fas fa-check"></i>
                    </button>
                </td>
                -->
                <td> {{ $t2->remarks }} </td> 
                <td> 
                    
              
                
                <td>
                    <button class="btn-sm btn-warning " data-toggle="modal" data-target="#pendingModal"
                            data-id="{{ $t2->id }}"
                            data-code="{{ $t2->code }}"
                            data-title="{{ $t2->title }}"
                            data-denomination="{{ $t2->denomination }}"
                            data-limit="{{ $t2->maxamount }}"
                            data-enabled="@if(trim($t2->enabled) > 0){{"Yes"}}@else{{"No"}}@endif"
                            data-remarks="{{ $t2->remarks }}"
                    >
                                Edit
                    </button>
                </td>
                
                <td>
                    <button class="btn-sm btn-danger "  data-toggle="modal" data-target="#deletePendingModal" 
                    data-id="{{ $t2->id }}"
                    data-datetransaction="{{ $t2->date_transaction }}"
                    data-requestedby="{{ ucwords(strtolower($t2->first_name)) }} {{ ucwords(strtolower($t2->last_name)) }}"
                    data-email="{{ $t2->email }}"
                    data-amount="{{ $t2->amount }}"
                    data-status="{{ $t2->status }}"
                    data-investment="{{ $t2->investment_type }}"
                    data-remarks="{{ $t2->remarks }}"
                    >
                                <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
          
            @endforeach
            
            @foreach ($orgs2 as $t2)
            <tr>
                <td>   </td> 
                <td> {{ trim($t2->code) }} </td> 
                <td> {{ trim($t2->title) }} </td> 
                <td class="text-right"> {{ number_format(trim($t2->denomination), 2, '.', ',') }} </td> 
                <td class="text-right"> {{ number_format(trim($t2->maxdepositamt), 2, '.', ',') }} </td> 
                <td class="text-right"> {{ trim($t2->type) }} </td>
                <td> @if (trim($t2->full) > 0) {{ 
                    "Yes"
                }} 
                    @else {{
                    
                    "No"
                    }}
                    
                    @endif
                </td>
                 <td class="text-right"> {{ trim($t2->termlength) }} </td>
                <td class="text-right"> {{ trim($t2->payoutfrequency) }} </td>
                <td class="text-right"> {{ number_format(trim($t2->maxamount), 2, '.', ',') }} </td>
               
                <td> @if (trim($t2->enabled) > 0) {{ 
                    "Yes"
                }} 
                    @else {{
                    
                    "No"
                    }}
                    
                    @endif
                </td>
              
                <td> {{ $t2->remarks }} </td> 
                <td> 
                    
              
                
                <td>
                   
                </td>
                
                <td>
                    
                </td>
            </tr>
          
            @endforeach
            
            
             <tr>
                <td>   </td> 
                <td>   </td> 
                <td>   </td> 
               <td>   </td> 
                <td>   </td> 
                <td></td>
                <td>   </td> 
                <td>   </td> 
                <td>   </td> 
               <td>   </td> 
                
                <!--
                 <td>   </td>
                <td> {{ ucwords(strtolower($t2->first_name)) }} {{ ucwords(strtolower($t2->last_name)) }} </td>
       
                
                
                
                <td> {{ $t2->email }} </td>  
                
                <td> {{ $t2->amount }} <a href="{{ $t2->file_name }}" data-toggle="lightbox"><i class="far fa-file-alt"></i></a> </td> 
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
                -->
                <td>  </td> 
                <td> 
                    
                 </td> 
                <td>
                    <button class="btn-sm btn-success "   data-toggle="modal" data-target="#verifyModal"
                    data-id="{{ $t2->id }}"
                    data-datetransaction="{{ $t2->date_transaction }}"
                    data-requestedby="{{ ucwords(strtolower($t2->first_name)) }} {{ ucwords(strtolower($t2->last_name)) }}"
                    data-email="{{ $t2->email }}"
                    data-amount="{{ $t2->amount }}"
                    data-status="{{ $t2->status }}"
                    data-investment="{{ $t2->investment_type }}"
                    data-remarks="{{ $t2->remarks }}"
                    >
                                <i class="fas fa-check"></i>
                    </button>
                </td>
                
                <td>
                     
                </td>
                
                <td>
                     
                </td>
            </tr>

        @endif
  @endisset
    
    
    </tbody>
    </table>
    <table class="table table-sm">
        <tr>
         <td>  {{$orgs->links("pagination::bootstrap-4")}}</td>
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
    </table>

  @if (count($orgs) > 0)
    
        
        
         
        
            </div> <!-- end col -->
        </div>   <!-- end row -->           
    </div> <!-- end container -->              
  
    <!-- MODALS -->
	 
	
	
	<!-- To del MODAL -->
	
	<div class="modal fade" id="deletePendingModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <form id="deletePendingForm" action="{{ route('manageorg.delete',$t2->id) }}" method="post">
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
    							<label for="">Delete Entry</label>
    							<input id="deleteId" name="deleteId" type="text" class="form-control">
    						 
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
			    <form id="verifyForm" action="{{ route('manageorg.add',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Add Entry</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				        <div class="form-group">
    						    
    					 
    							<label for="">Code</label>
    							<input id="addCode" name="addCode" type="text" class="form-control" placeholder="Code Here ex OOI3">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Title</label>
    							<input id="addTitle" name="addTitle" type="text" class="form-control" placeholder="Title Here ex Organic Options">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Denomination</label>
    							<input id="addDenomination" name="addDenomination" type="text" class="form-control" value="10000">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Limit</label>
    							<input id="addLimit" name="addLimit" type="text" class="form-control" value="0">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Enabled</label>
    							<input id="addEnabled" name="addEnabled" type="text" class="form-control" value="Yes">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Remarks</label>
    							<input id="addRemarks" name="addRemarks" type="text" class="form-control">
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
        					<button type="submit" class="ml-auto btn btn-success mr-auto" >Confirm Add Entry</button>
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
			    <form id="pendingForm" action="{{ route('manageorg.edit',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Edit Entry</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				
    					  <div class="form-group">
    						    <input id="editId" name="editId" type="hidden" class="form-control">
    					 
    							<label for="">Code</label>
    							<input id="editCode" name="editCode"  type="text"  class="form-control">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Title</label>
    							<input id="editTitle" name="editTitle" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Denomination</label>
    							<input id="editDenomination" name="editDenomination" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Limit</label>
    							<input id="editLimit" name="editLimit" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Enabled</label>
    							<input id="editEnabled" name="editEnabled" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    						    
    					 
    							<label for="">Remarks</label>
    							<input id="editRemarks" name="editRemarks" type="text" class="form-control">
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
        					<button type="submit" class="ml-auto btn btn-warning mr-auto" >Confirm Edit Entry</button>
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
     
    })
    
     $('#verifyModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //var id = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
     
     
    })

     $('#pendingModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //var id = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
     
        modal.find('.modal-body #editId').val(button.data('id'))
        modal.find('.modal-body #editCode').val(button.data('code'))   
        modal.find('.modal-body #editTitle').val(button.data('title')) 
        modal.find('.modal-body #editDenomination').val(button.data('denomination')) 
        modal.find('.modal-body #editLimit').val(button.data('limit')) 
        modal.find('.modal-body #editEnabled').val(button.data('enabled')) 
        modal.find('.modal-body #editRemarks').val(button.data('remarks')) 
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
