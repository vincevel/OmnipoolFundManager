<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;

//use App\Export\invoice;
use App\Export\Rep1Export;


use App\TransactionSync;
use App\Transaction;
use Excel;
use Storage;
use DB;
use Carbon\Carbon;
use App\OrgUser;
use App\OrgUser2;
use App\OrgTest;


class OrgReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    
    public $currdate;
    public $currinvestment;
     
     
    public function orgnetreportmain(){
        
        $data = Transaction::select('investment_type')
        ->whereNotIn('investment_type',array('SEDPI','Class A','Class B','Class D','Class E','Pag-Ibig P1','Pag-Ibig MP2','Pag-Ibig','MAF23','MAF33','OOI99'))
        ->orderBy('investment_type','asc')
        ->distinct()->get(); 
        //$tdate = '03/11/2021';
        $tdate = date('m/d/Y');
        return view('orgnetreport.chooseorgnetreport', [
               'tdate' => $tdate,
             'investments' => $data,
            
            
        ]); 
    }
    
    public function convertdate($date){
        $tdate = explode("/",$date);
        $ndate = $tdate[2] . "-" . $tdate[0] . "-" . $tdate[1];
        
        return $ndate;
    }
    
    public function orgnetReportc(Request $r1){

        dd($r1);
    }

    public function orgnetReport(Request $r1){



        $this->currinvestment = $r1->investment1;

        if($r1->testb2){
            //EXCEL CASE
            if ($this->currinvestment == "View all SRIs"){
                //ALL CASE
                $this->orgnetreport2($r1);
            } else {
                //SINGLE CASE
                $this->orgnetreport1($r1);
            }
        } else {
            //VIEW ONLY CASE
                $this->currdate = $this->convertdate($r1->date1);
                $this->currinvestment = $r1->investment1;


            if ($this->currinvestment == "View all SRIs"){
                //ALL CASE
                $tdata = $this->orgnetreport3b($this->currdate,$this->currinvestment);
                //dd($tdata);
                $data2 = number_format($tdata[1], 2, '.', ',');
                $data3 = number_format($tdata[2], 2, '.', ',');
                $data4 = number_format($tdata[1] + $tdata[2], 2, '.', ',');
                return view('orgnetreport.vieworgnetreportall', [
                    'data' => $tdata[0],
                    'total' => $data2,
                    'total_wallet' => $data3,
                    'total_all' => $data4,
                ]); 
            } else {
                //SINGLE CASE
                $tdata = $this->orgnetreport3($this->currdate,$this->currinvestment);
                //$this->orgnetreport1($r1);
                //dd($tdata);
                $data2 = number_format($tdata[1], 2, '.', ',');
                return view('orgnetreport.vieworgnetreport', [
                    'data' => $tdata[0],
                    'total' => $data2,
                    'investment' => $r1->investment1,
                ]); 
            }
        }
    }
    
    public function orgnetreport2(Request $r1){
            //ALL EXCEL CASE

            $this->currdate = $this->convertdate($r1->date1);
            $this->currinvestment = $r1->investment1;
            $date = Carbon::now();
            $fdate = $date->format('ymd');


            $title = "sdfi sri outstanding balances " . $fdate;
            //$title = $this->currinvestment . " sri outstanding balance";
            //$title = $this->currinvestment . " sri outstanding balance" . $date1;

         Excel::create($title, function($excel) {

            // Set the title
            $excel->setTitle("sdfi sri outstanding balances");

            // Chain the setters
     
            $tdata = $this->orgnetreport3b($this->currdate,$this->currinvestment);

            $data = $tdata[0];
            
            $data2 = $tdata[1];
            $data2 = number_format($data2, 2, '.', ',');
            $data3 = $tdata[2];
            $data3 = number_format($data3, 2, '.', ',');
            $data4 = number_format($tdata[1] + $tdata[2], 2, '.', ',');
           
            //$data[]= 10000;
            //$data2 = $this->orgnetreportTotal($this->currdate,$this->currinvestment);

            $excel->sheet("$this->currinvestment", function ($sheet) use ($data,$data2,$data3,$data4) {
                
                $sheet->setOrientation('landscape');
                
                $sheet->setColumnFormat(array(
                        'B' => '#,##0.00',
                    ));
                    
                $count = count($data);    
                    
           
                $sheet->cell('A46', function($cell) use ($data2)  {
                        $cell->setValue("Total Outstanding"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                $sheet->cell('B46', function($cell) use ($data2)  {
                        $cell->setValue($data2); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                 $sheet->cell('A47', function($cell) use ($data3)  {
                        $cell->setValue("Total Wallet"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                $sheet->cell('B47', function($cell) use ($data3)  {
                        $cell->setValue($data3); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                 $sheet->cell('A48', function($cell) use ($data4)  {
                        $cell->setValue("Total Outstanding + Wallet"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                $sheet->cell('B48', function($cell) use ($data4)  {
                        $cell->setValue($data4); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });



                $sheet->fromArray($data, NULL, 'A6',true);
                
                $sheet->cell('A5', function($cell)   {
                        $cell->setValue("$this->currinvestment"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                $sheet->cell('A6', function($cell)   {
                        $cell->setValue("Name"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                /*    
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("SysId"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                */    
                
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("Outstanding"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });    

                $sheet->cell('B6', function($cell) use ($data2)  {
                        $cell->setValue($data2); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   

                /*   
                $sheet->cell('C3', function($cell)   {
                        $cell->setValue("Date"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                */    
                    
            });

        })->download('xlsx');
        
    }
    
    public function orgnetreport1(Request $r1){
            //SINGLE EXCEL CASE

            $this->currdate = $this->convertdate($r1->date1);
            $this->currinvestment = $r1->investment1;
            $date = Carbon::now();
            $fdate = $date->format('ymd');


            $title = $this->currinvestment . " sri outstanding balance " . $fdate;
            //$title = $this->currinvestment . " sri outstanding balance";
            //$title = $this->currinvestment . " sri outstanding balance" . $date1;

         Excel::create($title, function($excel) use ($title) {

            // Set the title
            $excel->setTitle($title);

            // Chain the setters
     
            $tdata = $this->orgnetreport3($this->currdate,$this->currinvestment);

            $data = $tdata[0];

            $data2 = $tdata[1];
            $data2 = number_format($data2, 2, '.', ',');
            //$data[]= 10000;
            //$data2 = $this->orgnetreportTotal($this->currdate,$this->currinvestment);

            $excel->sheet("$this->currinvestment", function ($sheet) use ($data,$data2) {
                
                $sheet->setOrientation('landscape');
                
                $sheet->setColumnFormat(array(
                        'B' => '#,##0.00',
                    ));
                

                    
                    
           
                $sheet->cell('B2', function($cell) use ($data2)  {
                        $cell->setValue("Total Outstanding"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                $sheet->cell('C2', function($cell) use ($data2)  {
                        $cell->setValue($data2); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });

                $sheet->fromArray($data, NULL, 'A3',true);
                
                $sheet->cell('A2', function($cell)   {
                        $cell->setValue("$this->currinvestment"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                $sheet->cell('A3', function($cell)   {
                        $cell->setValue("Name"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                /*    
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("SysId"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                */    
                
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("Outstanding"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });    
                    
                $sheet->cell('C3', function($cell)   {
                        $cell->setValue("Date"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                    
            });

        })->download('xlsx');
        
    }
     
    public function orgnetreport3($date,$org){
        //VIEW SINGLE CASE
        
        //echo "OrgNetReport";
        
        //$data = OrgUser::all();
        
        //$org = "Organic Options";
        
        //transaction date must be before or equal to selected date
        //$date;
        
        $data = Transaction::select('user_id','requested_by')->where('investment_type',$org)->where('status','Verified')->where('date_transaction','<=',$date)->where('user_id','<>',NULL)->distinct()->get(); 
    
 
    
        $users = array();
        
        foreach ($data as $item){
            
            $users[$item->user_id] = new OrgUser2($item->user_id,$item->requested_by,$date);
            //echo $item->user_id . "<BR>";
        }
        
        $data2 = OrgTest::where('investment_type',$org)->where('status','Verified')->where('date_transaction','<=',$date)->where('user_id','<>',NULL)->get();
        
        //$price = OrgTest::sum('price');
        
        
        foreach ($data2 as $item){
  
            
            $str1 = $item->transaction_type_id . "-" . $item->amount . "-" . $item->cpayout;
            
            $users[$item->user_id]->add($str1);
            
            $users[$item->user_id]->insert($item->transaction_type_id,$item->amount,$item->cpayout);
            
 
        }
        
        $orgTotal = 0;
        $output = array();
        foreach ($users as $item){
            
            //$item->say4() . "<BR>";
            $output[] = $item->say5();
            $orgTotal += $item->sayAmount();
        }
        //var_dump($output);
        $container = array();
        $container[0] = $output;
        $container[1] = $orgTotal;


        return $container;
        //$this->orgnetreport3($output);  
        
    } 
     
    public function orgnetreport3b($date,$org2){
        //VIEW ALL CASE
        //get all orgs
        $orgs = Transaction::select('investment_type')
        ->whereNotIn('investment_type',array('SEDPI','Class A','Class B','Class D','Class E','My Wallet','Pag-Ibig P1','Pag-Ibig MP2','Pag-Ibig','MAF23','MAF33','OOI99'))
        ->orderBy('investment_type','asc')
        ->distinct()->get(); 
 
        $total_wallet_adds = Transaction::whereIn('investment_type',array('My Wallet'))->whereIn('status',array('Verified'))->whereIn('transaction_type_id',array('1','7'))->sum('amount');
        $total_wallet_subtracts = Transaction::whereIn('investment_type',array('My Wallet'))->whereIn('status',array('Verified'))->whereIn('transaction_type_id',array('3','8'))->sum('amount');

    

        $outputdata = array();
        $outputdata2 = array();
        $subtotal = 0;
        foreach ($orgs as $org){
              $result = $this->orgnetreport3b1($date,$org->investment_type);
              $outputdata[] = array($org->investment_type,$result[1]);
              $subtotal += $result[1];
        }

        $outputdata2[0] = $outputdata;
        $outputdata2[1] = $subtotal;
        $outputdata2[2] = $total_wallet_adds - $total_wallet_subtracts;
        return $outputdata2;


    }    

     
    public function orgnetreport3b1($date,$org){
        
        //echo "OrgNetReport";
        
        //$data = OrgUser::all();
        
        //$org = "Organic Options";
        
        //transaction date must be before or equal to selected date
        //$date;
        
        $data = Transaction::select('user_id','requested_by')->where('investment_type',$org)->where('status','Verified')->where('date_transaction','<=',$date)->where('user_id','<>',NULL)->distinct()->get(); 
    
 
    
        $users = array();
        
        foreach ($data as $item){
            
            $users[$item->user_id] = new OrgUser2($item->user_id,$item->requested_by,$date);
            //echo $item->user_id . "<BR>";
        }
        
        $data2 = OrgTest::where('investment_type',$org)->where('status','Verified')->where('date_transaction','<=',$date)->where('user_id','<>',NULL)->get();
        
        //$price = OrgTest::sum('price');
        
        
        foreach ($data2 as $item){
  
            
            $str1 = $item->transaction_type_id . "-" . $item->amount . "-" . $item->cpayout;
            
            $users[$item->user_id]->add($str1);
            
            $users[$item->user_id]->insert($item->transaction_type_id,$item->amount,$item->cpayout);
            
 
        }
        
        $orgTotal = 0;
        $output = array();
        foreach ($users as $item){
            
            //$item->say4() . "<BR>";
            $output[] = $item->say5();
            $orgTotal += $item->sayAmount();
        }
        //var_dump($output);
        $container = array();
        $container[0] = $output;
        $container[1] = $orgTotal;


        return $container;
        //$this->orgnetreport3($output);  
        
    } 
   
    
   
   
}
