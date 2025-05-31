<br>
<h1>Show payout</h1> 
<br>
{{ $payout }}
<br>

<table>

{{ $payout->contribpayout }}

@foreach ($payout as $key => $fields)
<tr><td>{{ $key }}</td></tr>
  
@endforeach
</table>
<br>
 
