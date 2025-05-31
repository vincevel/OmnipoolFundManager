<?php

namespace App\Http\Controllers;

//use App\RegMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\regMail;
use App\Mail\certMail;

use App\Transaction;
use App\UserO;

use App\CertificateMailLog;

use PDF;

class RegMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('mail.mail');
    }

    public function prepareMail(Request $request)
    {
        //
        //return view('mail.mail');



        return view('mail.mail', [
            'data' => $request
            
        ]);
    }
    
    public function prepareMailCert($id)
    {
        //
        //return view('mail.mail');

        $transaction =  Transaction::findOrFail($id);    
        //$email = UserO::findOrFail($id);
        
        $user = UserO::where([
            ['id', '=', $transaction->user_id ],
        ])->limit(1)->get();



        
        
        if (file_exists( storage_path() . "/$id.pdf" )){
            
        }else {
         $name  = $transaction->first_name . " " . $transaction->last_name;
         $name = ucwords($name);
         $amount  = $transaction->amount;
         $date = $transaction->date_transaction;
         $org = $transaction->investment_type;
         $this->generate4($name,$amount,$date,$org,$id);
        }
   
    
    
       // return $user[0];

        return view('mail.mailcertprep', [
            'data' => $transaction,
            'user' => $user[0],
            
        ]);
    }

    public function send(Request $request)
    {
        
       if (isset($request->email)){

        $data = array(
            'email' => $request->email,

        );    

        $bcc = array();
        $bcc[] = "vvmanychat2020@gmail.com";
        if (isset($request->ccemail)){


            
            $bcc[] = $request->ccemail;
        }

        //if ($cc[]==NULL){
             
        //}
        //$cc[] = "";
        
        Mail::to($request->email)->bcc($bcc)->send(new regMail($data));


        //Mail::to($request->email)->cc($cc)->bcc($bcc)->send(new regMail($data));
    

        return back()->with('success','Email Sent');   
        } else {
            return redirect('/usermailerror');
        } 
    }
    
    public function certSend(Request $request)
    {
     if (isset($request->email)){

        $data = array(
            'email' => "vvmanychat2020@gmail.com",

        );    

        if (isset($request->ccemail)){

                //return $request->ccemail;
             
          
                $pos = strpos(trim($request->ccemail), ";"); 
                
                if ($pos !== false) {
                    //found case
                    
                    $ccgrp = explode(";",$request->ccemail);     
                         
                    foreach ($ccgrp as $item){
                        
                        if (trim($item)!=NULL){
                            
                          //  $cc[] = trim($item);
                        }
                        
                    }
                         
                } else {
                    //not found case
                  //   $cc[] = trim($request->ccemail);
                }
         
            
        }
            
         $cc[] = "vvmanychat2020@gmail.com";
         $cc[] = "lianne.tabug@sedpi.com"; 
         $cc[] = "irmacuello18@gmail.com";
         $cc[] = "diane.lumbao@sedpi.com";
         $cc[] = "dianelumbao@yahoo.com";
         $cc[] = "fadviento@gmail.com";
         $cc[] = "maliannedct@gmail.com";
         $cc[] = "vvmanychat2020@gmail.com";
        
        //$request->email = "vincentvelasco1232019@gmail.com";

        ////Mail::to($request->email)->cc($cc)->send(new regMail($data));
          // Mail::to("vincentvelasco1232019@gmail.com")->cc($cc)->send(new regMail($data));
        Mail::to($request->email)->cc($cc)->send(new certMail($data,$request->user_id));
        
        //foreach ($cc as $recipient){
            
        //    Mail::to($recipient)->send(new certMail($data,$request->user_id));
        //}
         $transaction =  Transaction::findOrFail($request->user_id);    
         $transaction->sent_certificate = 1;
         $transaction->save();
         
         $certificateMailLog =  new CertificateMailLog();    
         $certificateMailLog->certificate_id = $request->user_id;
         $certificateMailLog->save();

        $id = $request->user_id;
        
        unlink(storage_path() . "/$id.pdf");

        return redirect('/certificate')->with('success','Email Sent');   
        
        } else {
             return redirect('/sri/certificate');
        } 
        
        
    }

    public function certSend2(Request $request)
    {
        
       if (isset($request->email)){
        


        $data = array(
            'email' => 'vvmanychat2020@gmail.com',
            //'email' => $request->email,
        );    

        if (isset($request->ccemail)){

            $cc[] = $request->ccemail;
        }

        $cc[] = "vvmanychat2020@gmail.com";
        
        //return $request->email;

        Mail::to($request->email)->cc($cc)->send(new certMail($data,$request->user_id));
    
        //Mail::to('vincentvelasco1232019@gmail.com')->cc($cc)->send(new certMail($data,$request->user_id));


        return redirect('/certificate')->with('success','Email Sent');   
        } else {
            return redirect('/sri/certificate');
        } 
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegMail  $regMail
     * @return \Illuminate\Http\Response
     */
    public function show(RegMail $regMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegMail  $regMail
     * @return \Illuminate\Http\Response
     */
    public function edit(RegMail $regMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegMail  $regMail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegMail $regMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegMail  $regMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegMail $regMail)
    {
        //
    }

      public function presentNumber($num){

        return number_format($num,2);

    }

  function numberTowords($number) {

            $number = str_replace(",","", $number);
        $number = (float)$number;
        $number += 0.00;

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->numberTowords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->numberTowords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->numberTowords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->numberTowords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
 
 public function multiple10k($num){
          
          $quotient = intval($num / 10000);
          $num = $quotient * 10000;
          
          
          return $num;
      }
     


      public function generate4($name,$amount,$date,$org,$id){
        
        $amount = (float)$amount;
        $amount += 0.00;
        
        $amount = $this->multiple10k($amount);
        
        $amount = $this->presentNumber($amount);

        $amountb = $this->numberTowords($amount);
        // create new PDF document
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        PDF::SetCreator("Sedpi");
        PDF::SetAuthor('SEDPI');
        PDF::SetTitle('SEDPI Joint Certificate');
        //$pdf->SetSubject('TCPDF Tutorial');
        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set header and footer fonts
        PDF::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(0);
        PDF::SetFooterMargin(0);

        // remove default footer
        PDF::setPrintFooter(false);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
        $img_file = K_PATH_IMAGES.'jcert.jpg';
        //PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        // set image scale factor
        //PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            PDF::setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        PDF::SetFont('Times', '', 16);

        // add a page


        PDF::AddPage();
        $html = "<p><span class=\"white\">........</span>This is to certify that <strong><span class=\"underline\">$name</span></strong> contributed the amount of Php$amount (<span class=\"capitalize\">$amountb</span>) as co-joint venture of <strong>SEDPI Development Finance, Inc.</strong> for the joint venture project with ($org)</p>
            
            <p><span class=\"white\"></span>In witness whereof, this Certificate signed by SDFI duly authorized officers on this ($date).</p>
            
            <style>

                .underline {
                    text-decoration: underline;
                }

                .capitalize {

                    text-transform: capitalize;
                }

                .white {

                    color: white;
                }

            </style>

        ";
        
              $img_file = K_PATH_IMAGES.'jcert3.jpg';
 
       // PDF::Image($img_file, 0, 0, 345, 410, '', '', '', true, 600, '', false, false, 0, false, false, true);
     
       
   

        // -- set new background ---


        // get the current page break margin
        $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break
        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        //$img_file = 'jcert2.jpg';
        
          PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 600, '', false, false, 0);
           PDF::MultiCell(155, 10, '  '.$html."\n", false, 'J', false, 1, 30 ,120, true,0,true);
        // restore auto-page-break status
        PDF::SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        PDF::setPageMark();

 
        //Close and output PDF document
        if (file_exists( storage_path() . "/$id.pdf" )){
            
        }else {
         PDF::Output(storage_path() . "/$id.pdf", 'F');
        }
         //PDF::Output("$id.pdf", 'I');

     
          
    }
    
}
