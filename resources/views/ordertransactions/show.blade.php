
@extends('layouts.adminmaster')

@section('header1')
<h1 class="m-0">Order of Transactions</h1>
@endsection

@section('content')
<style>
 


</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            
    adsa
        </div>
    </div>
</div>
@endsection

@section('searchuser')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
              <table id="example2" class="table table-striped table-bordered table-responsive" style="">
            <thead>
                <tr>
                    <th>Date of Transaction</th>
                    <th>Last Name</th>
                    <th>USD Deposited</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date_transaction }}</td>
                        <td>{{ $transaction->lname }}</td>
                        <td class="text-right">$&nbsp{{ number_format($transaction->amount),2 }}</td>
                   
                    </tr>
                    @endforeach
             </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th> </th>
                    <th class="text-right">$&nbsp{{ number_format($grand_total, 2, ',', ' ') }}</th>
     
                    
                </tr>
            </tfoot>
        </table>
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
       $('#searchtable').DataTable({
        "order": [],
         "ordering": false 
      });

      $('#example2').DataTable({
        stateSave: true,
        paging: false
      });

        initDataTables(); 
    } );

  

  </script>

@endsection