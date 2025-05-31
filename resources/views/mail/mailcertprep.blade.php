<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-US"  class="supernova"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="alternate" type="application/json+oembed" href="https://www.jotform.com/oembed/?format=json&amp;url=https%3A%2F%2Fform.jotform.com%2F200941313819048" title="oEmbed Form">
<link rel="alternate" type="text/xml+oembed" href="https://www.jotform.com/oembed/?format=xml&amp;url=https%3A%2F%2Fform.jotform.com%2F200941313819048" title="oEmbed Form">
<meta property="og:title" content="Send Email" >
<meta property="og:url" content="https://form.jotform.com/200941313819048" >
<meta property="og:description" content="Please click the link to complete this form.">
<meta name="slack-app-id" content="AHNMASS8M">
<link rel="shortcut icon" href="https://cdn.jotfor.ms/favicon.ico">
<link rel="canonical" href="https://form.jotform.com/200941313819048" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=1" />
<meta name="HandheldFriendly" content="true" />
<title>Send Email</title>
<link href="https://cdn.jotfor.ms/static/formCss.css?3.3.16671" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="https://cdn.jotfor.ms/css/styles/nova.css?3.3.16671" />
<link type="text/css" media="print" rel="stylesheet" href="https://cdn.jotfor.ms/css/printForm.css?3.3.16671" />
<link type="text/css" rel="stylesheet" href="https://cdn.jotfor.ms/themes/CSS/566a91c2977cdfcd478b4567.css?"/>
<style type="text/css">
    .form-label-left{
        width:150px;
    }
    .form-line{
        padding-top:12px;
        padding-bottom:12px;
    }
    .form-label-right{
        width:150px;
    }
    body, html{
        margin:0;
        padding:0;
        background:#fff;
    }

    .form-all{
        margin:0px auto;
        padding-top:0px;
        width:690px;
        color:#555 !important;
        font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Verdana, sans-serif;
        font-size:14px;
    }
</style>

<style type="text/css" id="form-designer-style">
    /* Injected CSS Code */
.form-label.form-label-auto { display: block; float: none; text-align: left; width: inherit; } /*__INSPECT_SEPERATOR__*/
    /* Injected CSS Code */
</style>

<script src="https://cdn.jotfor.ms/static/prototype.forms.js" type="text/javascript"></script>
<script src="https://cdn.jotfor.ms/static/jotform.forms.js?3.3.16671" type="text/javascript"></script>
<script type="text/javascript">
  JotForm.init(function(){
if (window.JotForm && JotForm.accessible) $('input_3').setAttribute('tabindex',0);
if (window.JotForm && JotForm.accessible) $('input_4').setAttribute('tabindex',0);
if (window.JotForm && JotForm.accessible) $('input_5').setAttribute('tabindex',0);
  JotForm.newDefaultTheme = false;
      JotForm.alterTexts(undefined);
  JotForm.clearFieldOnHide="disable";
  JotForm.submitError="jumpToFirstError";
    /*INIT-END*/
  });

   JotForm.prepareCalculationsOnTheFly([null,{"name":"sendEmail","qid":"1","text":"Send Email","type":"control_head"},{"name":"sendmail","qid":"2","text":"Send Mail","type":"control_button"},{"description":"","name":"to","qid":"3","subLabel":"","text":"To:","type":"control_textbox"},{"description":"","name":"ccplease","qid":"4","subLabel":"","text":"CC: (Please input your email address - Optional)","type":"control_textbox"},{"description":"","name":"email","qid":"5","subLabel":"","text":"Email:","type":"control_textarea"}]);
   setTimeout(function() {
JotForm.paymentExtrasOnTheFly([null,{"name":"sendEmail","qid":"1","text":"Send Email","type":"control_head"},{"name":"sendmail","qid":"2","text":"Send Mail","type":"control_button"},{"description":"","name":"to","qid":"3","subLabel":"","text":"To:","type":"control_textbox"},{"description":"","name":"ccplease","qid":"4","subLabel":"","text":"CC: (Please input your email address - Optional)","type":"control_textbox"},{"description":"","name":"email","qid":"5","subLabel":"","text":"Email:","type":"control_textarea"}]);}, 20); 
</script>
</head>
<body>

<!-- FORM -->

<form class="jotform-form" action="/sri/certificate/mailsend" method="post" name="" id="" accept-charset="utf-8" autocomplete="on">
  {{ csrf_field() }}
  <input type="hidden" name="formID" value="200941313819048" />
  <input type="hidden" id="JWTContainer" value="" />
  <input type="hidden" id="cardinalOrderNumber" value="" />
  <div role="main" class="form-all">
    <ul class="form-section page-section">
      <li id="cid_1" class="form-input-wide" data-type="control_head">
        <div class="form-header-group  header-default">
          <div class="header-text httal htvam">
            <h2 id="header_1" class="form-header" data-component="header">
              Send Email
            </h2>
          </div>
        </div>
      </li>
      </li>
      <li class="form-line" data-type="control_textbox" id="id_3">
        @if($message = Session::get('successs') )
           <strong style="color:green">Message Sent Successfully</strong>


        @else

       


        @isset($data) 
        <label class="form-label form-label-top form-label-auto" id="label_3" for="input_3"> To: {{ $data->last_name . ", " . $data->first_name  }} </label>
        <input type="hidden" id="user_id" name="user_id" value="{{ $data->id }}">
        
        <div id="cid_3" class="form-input-wide">
           
        
          <input type="text" id="input_3" name="email" data-type="input-textbox" class="form-readonly form-textbox" size="40" 
          value="{{ $user->user_email }}" tabindex="-1" data-component="textbox" aria-labelledby="label_3" readonly="" />
        
          
        </div>
         @endisset

         @endif
      </li>
      <li class="form-line" data-type="control_textbox" id="id_4">
        <label class="form-label form-label-top form-label-auto" id="label_4" for="input_4"> CC: (Please input your email address - Optional) </label>
        <div id="cid_4" class="form-input-wide">
          <input type="text" id="input_4" name="ccemail" data-type="input-textbox" class="form-textbox" size="40" value="lianne.tabug@sedpi.com;
irmacuello18@gmail.com;diane.lumbao@sedpi.com" data-component="textbox" aria-labelledby="label_4" />
        </div>
      </li>
      <li class="form-line" data-type="control_textarea" id="id_5">
        <label class="form-label form-label-top form-label-auto" id="label_5" for="input_5"> Email: </label>
        <div id="cid_5" class="form-input-wide">
          <textarea id="input_5" class="form-textarea" name="q5_email" cols="60" rows="12" data-component="textarea" aria-labelledby="label_5" readonly>Greetings!&#13&#13&#13&#13Attached herewith is you certificate of Joint Venture Contribution as proof of your partnership with SEDPI&#13&#13Please check if the details are all correct. For corrections or other concerns, feel free to contact us.&#13&#13&#13&#13Thank You for supporting SEDPI SRI!&#13&#13&#13&#13Regards,&#13&#13SRI Investments&#13&#13
          </textarea>


         
        </div>
      </li>
      <li class="form-line" data-type="control_button" id="id_2">
        <div id="cid_2" class="form-input-wide">
          <div style="margin-left:156px" data-align="auto" class="form-buttons-wrapper  ">
            @if($message = Session::get('successs') )

            @else
                
                @if(file_exists( storage_path() . "/$data->id.pdf" ))
                    
                    <button id="input_2" type="submit" class="form-submit-button" data-component="button" data-content="">
                        Send Mail
                    </button>
                
                
                @else
                
                    <span style="color:red">PLEASE GENERATE CERT FIRST</span>
                
                @endif
            
            @endif
            <a href="/sri/certificate" class="form-submit-button" data-component="button" data-content="">Back</a>
            
          </div>
        </div>
      </li>
      <li style="display:none">
        Should be Empty:
        <input type="text" name="website" value="" />
      </li>
    </ul>
  </div>
  <script>
  JotForm.showJotFormPowered = "new_footer";
  </script>
  <script>
  JotForm.poweredByText = "Powered by JotForm";
  </script>
  <input type="hidden" id="simple_spc" name="simple_spc" value="200941313819048" />
  <script type="text/javascript">
  document.getElementById("si" + "mple" + "_spc").value = "200941313819048-200941313819048";
  </script>
  <div class="formFooter-heightMask">
  </div>
  <div class="formFooter f6">
    
  </div>
</form>


<!-- FORM -->

</body>
</html>
<script type="text/javascript">JotForm.ownerView=true;</script>