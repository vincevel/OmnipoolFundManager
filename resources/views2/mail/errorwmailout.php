<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Error: Messenger SRI Investments Withdraw</title>
</head>
<body>
Dear {{ $data["requested_by"] }},
<BR>
<BR>  
<p>
ERROR - Your Php{{ $data["amount"] }} withdraw on {{ $data["date_transaction"] }} to {{ $data["investment_type"] }} has been registered in the system.
It is now <strong style="color:orange">PENDING</strong> and is under our review. 
</p>
<BR>
    
@isset($data["remarks"])

    @if(trim($data["remarks"])!=NULL)
    Please also take note of the following comments on your withdraw:    
    <BR>
    <p>{{ $data["remarks"] }}</p>
    

            <p>Please Resubmit your Request.</p>

    @endif
@endisset    
<BR>
<BR>
Please do not reply to this email.      
<BR>    
For corrections or other concerns, feel free to contact us:<BR>

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


