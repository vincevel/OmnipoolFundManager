<div>
    @if(Auth::user()->admin==1)<h2 class="pt-2  ">{{ ucwords($user->last_name) }}, {{ ucwords($user->first_name) }}</h2>@endif
    
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h5>$&nbsp{{$total_deposited}}</h5>
                    <p>Total Balance</p>
                </div>
            </div>
            
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h5>@if($total_deposited>0){{$current_tier}}@else Closed @endif</h5>
                    <p>@if($total_deposited>0)Next Tier ${{$amount_to_next_tier}}@else-@endif</p>
                </div>
            </div>
            
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    
                    <h5>$&nbsp{{$total_payouts}}</h5>
                    <p>Total Payouts</p> 
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h5>$&nbsp{{$total_dispersed}}</h5>
                    <p>Total Dispersed</p>
                </div>
            </div>
            
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    
                    <h5>$&nbsp{{$total_defered}}</h5>
                    <p>Total Deffered</p> 
                </div>
            </div>
        </div>
        
        
        
    </div>
    
</div>
<div class="row">
    <div class="col-lg-12 col-12">
        @if(Auth::user()->admin==1)
            <a href="{{ route('payout_breakdown_admin',$user->id) }}" class="btn btn-primary mb-3 align-right">Full Summary</a>
        @else
            <a href="{{ route('payout_breakdown_user') }}" class="btn btn-primary mb-3 align-right">Full Summary</a>
        @endif
        <span data-href="/exportPayouts/{{$user->id}}/1" id="export" class="btn btn-success push-right mb-3 align-right" onclick="exportPayouts(event.target);">Export CSV</span>   
    </div>
    <div class="col-lg-12 col-12">
        <table style="1px solid black; width:100%" class="table table-bordered table-striped table-lg">
            <thead>
              <tr>
                <th scope="col">Month</th>
                <th scope="col" class="text-right">Monthly Payouts</th>
                <th>Payout Type</th>
                
              </tr>
            </thead>
            <tbody>
            @foreach ($payouts as $payout)
                
              <tr>
                <th>{{$payout->month}}</th>
                <th class="text-right">$&nbsp{{number_format($payout->amount,2)}}</th>
                <th>{{$payout->isDeferred}}</th>
    
              </tr>
              
                @endforeach
             
            </tbody>
          </table>
    </div>
    
</div>
<script>
    function exportPayouts(_this) {
       let _url = $(_this).data('href');
       window.location.href = _url;
    }
 </script>