@extends('layouts.master')
@section('header1')
<h1 class="m-0">Payouts</h1>
@endsection

@section('searchuser')
<table style="1px solid black; width:100%" class="table table-bordered table-condensed table-sm">
    <thead>
      <tr>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col" class="text-right">Current Payout</th>
        <th scope="col" class="text-right">Next Month Payout</th>
        <th scope="col">Current Month Defered</th>
        <th scope="col">Next Month Defered</th>
        <th scope="col" class="text-right">Total Balance</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($payouts as $i=>$payout)
        <tr>
            <td>{{$payout->first_name}}</td>
            <td>{{$payout->last_name}}</td>
            <td class="text-right">$&nbsp {{$payout->curr_payout}}</td>
            <td class="text-right">$&nbsp {{$payout->next_month_payout_total}}</td>
            <td>@if($payout->isDeferred1==1)True @else False @endif</td>
            <td>@if($payout->isDeferred2==1)True @else False @endif</td>
            <td class="text-right">$&nbsp {{$payout->total_balance}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection