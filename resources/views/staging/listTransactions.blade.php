<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Staging Transactions</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
</head>

<body>
<div class="Jumbotron">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-3 ml-3">Staging Area</h1>
        </div>
    </div>
</div>
      
<div class="container">
   @isset($transactions)  
        @if (count($transactions) > 0)
       
              <table class="table table-sm table-responsive">
              <thead>
                <tr>
                    <th> Pending  </th>
                    <th> Delete  </th>
                    <th> requested_by  </th>
                    <th> email  </th>  
                    <th> date_transaction  </th> 
                    <th> amount  </th> 
                    
                    <th> running_balance  </th> 
                    <th> remarks  </th> 
                    <th> status  </th> 
                    <th> investment_type  </th>  
                    <th> user_id  </th> 
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
             
                  
                </tr>
              </thead>
              <tbody>
                
   
            @foreach ($transactions as $t2)
            <tr>
                <td>
                    <button class="btn-sm btn-primary mt-3" data-id="{{ $t2->id }}" data-toggle="modal" data-target="#addPendingModal">
                                To Pending
                    </button>
                </td>
                
                <td>
                    <button class="btn-sm btn-danger m-3" data-id="{{ $t2->id }}" data-toggle="modal" data-target="#deletePendingModal">
                                Delete
                    </button>
                </td>
                
                <td> {{ $t2->requested_by }} </td>
                <td> {{ $t2->email }} </td>  
                <td> {{ $t2->date_transaction }} </td> 
                <td> {{ $t2->amount }} </td> 
                 
                <td> {{ $t2->running_balance }} </td> 
                <td> {{ $t2->remarks }} </td> 
                <td> {{ $t2->status }} </td> 
                <td> {{ $t2->investment_type }} </td>  
                <td> <a href="{{ route('showuser',$t2->user_id) }}" target="_blank">{{ $t2->user_id }}</a></td> 
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
                 
            </tr>
          
            @endforeach

        @endif
  @endisset
  
  @if (count($transactions) > 0)
  </div>
    </tbody>
    </table>
    <div class="container">
        <div class="row">
            <div class="col-6">
                            <form target="_blank" action="{{ url('staging/transfer') }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
                        <label for="input_5_0_1" >
                            <button id="input_2" type="submit" class="btn-sm btn-primary mt-3" data-component="button" data-content="">
                                Transfer
                            </button>
                        </label>
                    </form>
            </div>
            <div class="col-6">
                     <form target="_blank" action="{{ url('staging/transfer/clear') }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
                        <label for="input_5_0_1" >
                            <button id="input_2" type="submit" class="btn-sm btn-danger mt-3" data-component="button " data-content="">
                                Clear Records
                            </button>
                        </label>
                    </form>
            </div>
        </div>           
    </div>     
    
        
            
                        
     <div class="container">
        <div class="row">
            <div class="col-6">
                          <label for="input_5_0_1" >
                            <button onClick="location.reload()" id="input_2" type="submit" class="btn-sm btn-warning mt-5" data-component="button" data-content="">
                                Reload
                            </button>
                        </label>
                    
            </div>
            <div class="col-6">
                     <form target="_blank" action="{{ url('staging/transfer/clear') }} " method="get" name="" id="" accept-charset="utf-8" autocomplete="on"> 
        {{ csrf_field() }}
                        <label for="input_5_0_1" >
                            <!--
                            <button id="input_2" type="submit" class="btn-sm btn-danger mt-5" data-component="button " data-content="">
                                Button2
                            </button>
                            -->
                        </label>
                    </form>
            </div>
        </div>           
    </div>             
  
    <!-- MODALS -->
	<!-- To Pending MODAL -->
	
	<div class="modal fade" id="addPendingModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <form id="addPendingForm" action="{{ route('test.one',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Set To Pending</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				
    						<div class="form-group">
    							<label for="">Transfer the Following ID to Pending</label>
    							<input id="itemId" name="itemIdN" type="text" class="form-control">
    						</div>
    						
    						<div class="form-group">
    						    <button type="submit" class="btn btn-primary mr-auto" >Save</button>
    						</div>    
    					
    				</div>
    				<!-- End modal body -->
                    </form>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-primary mr-auto" data-dismiss="modal" >Close</button>
    				</div>
    				<!-- End modal footer -->
				
			</div>
		</div>
	</div>
	<!-- End To Pending MODAL -->
	
	
	<!-- To del MODAL -->
	
	<div class="modal fade" id="deletePendingModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <form id="deletePendingForm" action="{{ route('staging.delete',$t2->id) }}" method="post">
			 <!-- <form id="addPendingForm" action="https://www.vincerapisura.com/sri/staging/transfer/3" method="get"> -->
			    {{ csrf_field() }}
			    {{ method_field('PATCH') }}
    				<div class="modal-header bg-primary text-white">
    					<h5 class="modal-title">Delete</h5>
    					<button class="close" data-dismiss="modal">
    						<span>&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    				
    				
    						<div class="form-group">
    							<label for="">Delete Entry</label>
    							<input id="itemIdDel" name="itemIdNDel" type="text" class="form-control">
    						</div>
    						
    						<!--
    						<div class="form-group">
    						    <button type="submit" class="btn btn-primary mr-auto" >Save</button>
    						</div>    
    					    -->
    				</div>
    				<!-- End modal body -->
                 
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-primary mr-auto" >Save</button>
    				</div>
    				</form>
    				<!-- End modal footer -->
				
			</div>
		</div>
	</div>
	<!-- End To del MODAL -->
	
	<!-- END MODALS -->
        @endif    
  
 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

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
      var id1 = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      
      //modal.find('.modal-title').text('New message to ' + recipient)
      //modal.find('.modal-body input').val(recipient)
      //modal.find('.modal-title').text('New message to ' + recipient)

      //set input value
      modal.find('.modal-body #itemIdDel').val(id1)
      //set form value
      //modal.find('.modal-body #addPendingForm').attr('action', 'https://www.vincerapisura.com/sri/staging/transfer/' + id1)
      
 
    })

    

</script>

 </body>

</html>
