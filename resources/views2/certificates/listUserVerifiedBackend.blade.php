<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>View Joint Venture Certificate</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
</head>

<body>
 
      <br>

<div class="container">
     @isset($transactions)  
            @if (count($transactions) > 0)
            <div class="my-5">
                
                <a class="navbar-brand p-3 btn btn-outline-secondary lead"  >My Joint Venture Certificates - {{ ucwords(trim($transactions[0]->last_name)) . ", " . ucwords(trim($transactions[0]->first_name)) }}</a>
            </div>
            @endif
        @endisset
    
      <table class="table table-sm table-striped">
  <thead>
    <tr>
      <th >Date</th>
      <th >Investment</th>   
      <th  class="text-right">Amount</th>
      
      <th ></th>
      
    </tr>
  </thead>
  <tbody>
      
    @isset($transactions)  
        @if (count($transactions) > 0) 
           @foreach ($transactions as $transaction)
            @if ($transaction->investment_type == "MARZAN1" || $transaction->investment_type == "MADDELA1")
                @if ($transaction->amount >= 100000)
                    <tr>
                      <td>{{ $transaction->date_transaction }}</td>
                      
                      <td>{{ $transaction->investment_type }}</td>
                      <td class="text-right">{{ $transaction->amount }}</td>
                     
                      
                      <td class="text-center">
                          <form action="/sri/certificate/{{ $transaction->id }}" method="GET">
                                {{ csrf_field() }}
                                
                                <button class="btn-xs btn-primary">Download</button>
                            </form>
                       </td>
                      
                      
                 </tr>
                
                
                @endif
            @else 
                  <tr>
                      <td>{{ $transaction->date_transaction }}</td>
                      <!-- <td>{{ ucwords(trim($transaction->last_name)) . ", " . ucwords(trim($transaction->first_name)) }}</td> -->
                       <td>{{ $transaction->investment_type }}</td>
                      <td class="text-right">{{ $transaction->amount }}</td>
                     
                      
                      <td class="text-center">
                          <form action="/sri/certificate/{{ $transaction->id }}" method="GET">
                                {{ csrf_field() }}
                                
                                <button class="btn-xs btn-primary">Download</button>
                            </form>
                       </td>
                      
                      
                 </tr>
             @endif
            @endforeach  
        @endif
    @endisset
    
     
  </tbody>
</table>
</div>      
      
             <div class="container">
            <a class="btn btn-xs btn-outline-secondary mt-5" href="/sri/viewuser">Back</a>
          </div>

 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

 </body>

</html>
