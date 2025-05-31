all users

<table border=1>
@foreach ($users as $user)
<tr>
<td>{{$user->email}}</td>
<td>{{$user->last_name}}</td>
<td>{{$user->first_name}}</td>
<td>{{$user->plainpass}}</td>
<td>{{$user->address_line1}}</td>
<td>{{$user->address_line2}}</td>
<td>{{$user->city}}</td>
<td>{{$user->state_province}}</td>
<td>{{$user->postal_zip_code}}</td>
<td>{{$user->country}}</td>
</tr>
@endforeach
</table>