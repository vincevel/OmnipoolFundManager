<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Denied: SRI Investments Re-Investment Request</title>
</head>
<body>
Dear {{ $data["requested_by"] }},
<BR>
<BR>  
Apologies, your Php{{ $data["amount"] }} reinvestment request on {{ $data["date_transaction"] }} to {{ $data["investment_type"] }} has been <strong style="color:red">DENIED</strong>.
<BR>
@if (count($data["notes"]) > 0)
Reason/s are the following:<BR>
 @foreach ($data["notes"] as $emsg)
    {{ $emsg }} <BR>
 
 @endforeach
@endif
<BR>
Please resubmit your request.<BR>
<BR>
Please do not reply to this email.      
<BR>    
For corrections or other concerns, feel free to contact us:<BR>
<BR> 
Ma Lianne<BR>
via messenger: <BR>    
https://m.me/maliannedct  <BR> 
 
<BR>
<BR>
<BR>
Access to the SRI Investments Site is via - https://www.vincerapisura.com/sedpi-socially-responsible-investment/<BR>
<BR>
Thank you for supporting SEDPI SRI!<BR>
<BR>
<BR>    
Regards,<BR>
SRI Investments
</body>
</html>


