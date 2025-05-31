@extends('layouts.adminmaster')
@section('header1')
<h1 class="m-0">Payouts DB</h1>
@endsection

@section('searchuser')
<div class="row">
  <div class="col-lg-4 col-6">
      <div class="small-box bg-info">
          <div class="inner">
              <h6>Current Month's Payouts $&nbsp{{number_format($curr_payouts,2,'.',',')}}</h6>
              <h6>Current Month's Defers $&nbsp{{number_format($curr_defers,2,'.',',')}}</h6>
          </div>
      </div>
      
  </div>
  <div class="col-lg-4 col-6">
      <div class="small-box bg-warning">
          <div class="inner">
              <h6>Next Month's Payouts $&nbsp{{number_format($next_payouts,2,'.',',')}}</h6>
              <h6>Next Month's Defers $&nbsp{{number_format($next_defers,2,'.',',')}}</h6>
          </div>
      </div>
      
  </div>
  <div class="col-lg-4 col-6">
      <div class="small-box bg-success">
          <div class="inner">
              <div class="icon"><i class="fa-solid fa-building-columns"></i></div>
              <h4>$&nbsp{{number_format($total_balance,2,'.',',')}}</h4>
              <p>Total Balance</p>
          </div>
      </div>
      
  </div>
  
  
</div>
<table style="1px solid black; width:100%" class="table table-bordered table-striped table-lg">
    <thead>
      <tr>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Payout</th>
        <th scope="col">Defers</th>
        <th scope="col" class="text-right">This Month's Payout</th>
        <th scope="col" class="text-right">Next Month's Payout</th>
        <th scope="col">Current Month Deffered</th>
        <th scope="col">Next Month Deffered</th>
        <th scope="col">Interest Rate</th>
        <th scope="col" class="text-right">Total Balance</th>
        <th></th>
        <th></th>
       
      </tr>
    </thead>
    <tbody>
        @foreach ($payouts as $i=>$payout)
        <tr>
            <td>{{$payout->first_name}}</td>
            <td>{{$payout->last_name}}</td>
            <td class="text-right">@if($payout->isDeferred1==1)0 @else $&nbsp{{number_format($payout->curr_payout,2,'.',',')}} @endif</td>
            <td class="text-right">@if($payout->isDeferred1==1)$&nbsp{{number_format($payout->curr_payout,2,'.',',')}} @else 0 @endif</td>
            <td class="text-right">$&nbsp{{number_format($payout->curr_payout,2,'.',',')}}</td>
            <td class="text-right">$&nbsp{{number_format($payout->next_month_payout,2,'.',',')}}</td>
            <td>@if($payout->isDeferred1==1)D @else P @endif</td>
            <td>@if($payout->isDeferred2==1)D @else P @endif</td>
            <td>{{$payout->interest_rate}}%</td>
            <td class="text-right">$&nbsp{{number_format($payout->total_balance,2,'.',',')}}</td>
            <td><a href="{{ route('payout_monthly_admin',$payout->user_id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-money-check-dollar"></i></a></td>
            <td><a href="{{ route('get_user_transactions',$payout->user_id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-binoculars"></i></a>
            </td>
            
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
<div id="modalchangeinterestrate" >
            
    @foreach ($payouts as $payout)
    
  
        <div  class="modal fade" id="interestRateModal{{ $payout->user_id }}" tabindex="-1" role="dialog" aria-labelledby="interestRateModalLabel" aria-hidden="true" >
          <div class="modal-dialog" role="document">
        
        
            <div class="modal-content"   >
            <!--  <h1>hello world</h1> -->
              <changeinterestrate id="formtest" user_id="{{ $payout->user_id }}" interest="{{ $payout->interest_rate  }}"></changeinterestrate>
          
            </div>
              <input type="hidden" id="testing">
          </div>
        </div>
  
      
    @endforeach 
  </div>