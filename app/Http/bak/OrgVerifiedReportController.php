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
use App\TransactionMod1;
use Excel;
use Storage;
use DB;

use App\OrgUser;
use App\OrgUser2;
use App\OrgTest;

use App\DividendsToReleaseReport;
use App\RentalDividends\RentalDividends;

class OrgVerifiedReportController extends Controller
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
     
     
    public function orgverifiedreportmain(){
        
        $data = Transaction::select('investment_type')
        ->whereNotIn('investment_type',array('SEDPI','Class A','Class B','Class D','Class E','My Wallet','Pag-Ibig P1','Pag-Ibig MP2','Pag-Ibig','MAF23','MAF33','OOI99'))
        ->orderBy('investment_type','asc')
        ->distinct()->get(); 
        //$tdate = '03/11/2021';
        $tdate = date('m/d/Y');
        return view('orgverifiedreport.chooseorgverifiedreport', [
               'tdate' => $tdate,
             'investments' => $data,
            
            
        ]); 
    }
    
 
    
 
    
    public function orgverifiedreport(Request $r1){
        
        
          // $this->currdate = $this->convertdate($r1->date1);
          $this->currinvestment = $r1->investment1;
        
  
         Excel::create("VerifiedReport $this->currinvestment", function($excel) {

            // Set the title
            $excel->setTitle("VerifiedReport $this->currinvestment");

            // Chain the setters
   
            //processes data into array.
            $data = $this->getVerifiedEntries($this->currinvestment);
     
            if ($this->currinvestment == "All"){

                $excel->sheet("$this->currinvestment", function ($sheet) use ($data) {
                
                $sheet->setOrientation('landscape');
                
 
           
                $sheet->setColumnFormat(array(
                         'C' => '#,##0.00',
                ));  
                
                $sheet->fromArray($data, NULL, 'A3',true);
                
              
                
    
               
                    
                
                    
                    
            });


            } else {

                $excel->sheet("$this->currinvestment", function ($sheet) use ($data) {
                
                $sheet->setOrientation('landscape');
                
 
           
                $sheet->setColumnFormat(array(
                         'C' => '#,##0.00',
                ));  
                
                $sheet->fromArray($data, NULL, 'A3',true);
                
                $sheet->cell('A2', function($cell)   {
                        $cell->setValue("$this->currinvestment Verified Entries"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                $sheet->cell('A3', function($cell)   {
                        $cell->setValue("Date"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("Investment Type"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                
                $sheet->cell('C3', function($cell)   {
                        $cell->setValue("Amount"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });    
                    
                $sheet->cell('D3', function($cell)   {
                        $cell->setValue("Email"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('E3', function($cell)   {
                        $cell->setValue("Requested By"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('F3', function($cell)   {
                        $cell->setValue("Status"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('G3', function($cell)   {
                        $cell->setValue("Remarks"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                
                    
                    
            });

            }    

            

        })->download('xlsx');
        
    }
    
    public function getVerifiedEntries($org){
        
        //$data = TransactionMod1::select('transaction_type_id','date_transaction','investment_type','amount','email','requested_by','status','remarks')->where('investment_type',$org)->where('status','Verified')->where('user_id','<>',NULL)->orderBy('user_id','asc')->orderBy('date_transaction','asc')->get()->toArray(); 

        if ($org == "All"){

            $data = TransactionMod1::select('email','requested_by')->where('status','Verified')->where('user_id','<>',NULL)
            ->where('email','<>',NULL)
            ->where('requested_by','<>',NULL)
            ->whereIn('transaction_type_id',array(1,9))
            ->orderBy('email','asc')
            ->distinct()->get()->toArray(); 
        } else {
            $data = TransactionMod1::select('date_transaction','investment_type','amount','email','requested_by','status','remarks')->where('investment_type',$org)->where('status','Verified')->where('user_id','<>',NULL)->whereIn('transaction_type_id',array(1,9))->get()->toArray(); 

        }

        //$data = TransactionMod1::select('date_transaction','investment_type','amount','email','requested_by','status','remarks')->where('status','Verified')->where('user_id','=',34)->orderBy('investment_type', 'date')->get()->toArray(); 
 
        return $data;
        
     
    }
     
     public function dividendstoreleasereport(){
        
        
          // $this->currdate = $this->convertdate($r1->date1);
          //$this->currinvestment = $r1->investment1;
        
  
         Excel::create("Dividends To Release Report", function($excel) {

            // Set the title
            $excel->setTitle("Dividends To Release Report");

            // Chain the setters
   
            //processes data into array.
            $data = $this->getDividendsReportEntries();
                   //  dd($data);
             
            $excel->sheet("Dividends Release Report", function ($sheet) use ($data) {
                
                $sheet->setOrientation('landscape');
                
                $sheet->setColumnFormat(array(
                         'E' => '#,##0.00',
                         'I' => '#,##0.00'
                ));  
                
            
                $sheet->fromArray($data, NULL, 'A3',true);
                
            
                
                /*
                $sheet->cell('A2', function($cell)   {
                        $cell->setValue("$this->currinvestment Verified Entries"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                $sheet->cell('A3', function($cell)   {
                        $cell->setValue("Date"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("Investment Type"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                
                $sheet->cell('C3', function($cell)   {
                        $cell->setValue("Amount"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });    
                    
                $sheet->cell('D3', function($cell)   {
                        $cell->setValue("Email"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('E3', function($cell)   {
                        $cell->setValue("Requested By"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('F3', function($cell)   {
                        $cell->setValue("Status"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('G3', function($cell)   {
                        $cell->setValue("Remarks"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                */
                    
                    
            });

        })->download('xlsx');
        
    }

    public function rentalstoreleasereportmarzan(){
        
        
          // $this->currdate = $this->convertdate($r1->date1);
          //$this->currinvestment = $r1->investment1;
        
  
         Excel::create("Dividends To Release Report", function($excel) {

            // Set the title
            $excel->setTitle("Dividends To Release Report");

            // Chain the setters
   
            //processes data into array.
            $data = $this->getDividendsReportEntriesRentals();
                   //  dd($data);
             
            $excel->sheet("Dividends Release Report", function ($sheet) use ($data) {
                
                $sheet->setOrientation('landscape');
                
                $sheet->setColumnFormat(array(
                         'E' => '#,##0.00',
                         'I' => '#,##0.00'
                ));  
                
            
                $sheet->fromArray($data, NULL, 'A3',true);
                
            
                
                /*
                $sheet->cell('A2', function($cell)   {
                        $cell->setValue("$this->currinvestment Verified Entries"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                $sheet->cell('A3', function($cell)   {
                        $cell->setValue("Date"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("Investment Type"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                
                $sheet->cell('C3', function($cell)   {
                        $cell->setValue("Amount"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });    
                    
                $sheet->cell('D3', function($cell)   {
                        $cell->setValue("Email"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('E3', function($cell)   {
                        $cell->setValue("Requested By"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('F3', function($cell)   {
                        $cell->setValue("Status"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('G3', function($cell)   {
                        $cell->setValue("Remarks"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                */
                    
                    
            });

        })->download('xlsx');
        
    }
    
    public function getDividendsReportEntries2(){
        /*
        $data = DB::select('select * from dividends_to_release_apr2021_report');
        
        $output = array();
        foreach ($data as $item){
            $inner = array();
              $inner["date_transaction"] = $item->date_transaction;
              $inner["end_date"] = $item->end_date;
              $inner["days_between"] = $item->days_between;
              $inner["requested_by"] = $item->requested_by;
              $inner["amount"] = $item->amount;
              $inner["max_days"] = $item->max_days;
              $inner["rate"] = $item->rate;
              $inner["investment_type"] = $item->investment_type;
              $inner["date_transaction"] = $item->date_transaction;
              $inner["dividend_payout"] = $item->dividend_payout;
              $output[] = $inner;
        }
        
        //return $data;
          //    $data = TransactionMod1::select('date_transaction','investment_type','amount','email','requested_by','status','remarks')->where('status','Verified')->where('user_id','<>',NULL)->get()->toArray(); 
        return $output;
        
     //dd($data);
     */
    }
   
    
   public function getDividendsReportEntries(){
        
        
        //$data = DividendsToReleaseReport::where('investment_type','=','Perpetual Help Community Cooperative (PHCCI)')->get()->toArray(); 
        $data = DividendsToReleaseReport::get()->toArray(); 
        //     dd($data);
        return $data;
        
      
 
    }
    
    public function getRentalsReportEntries(){
        
        
        //$data = DividendsToReleaseReport::where('investment_type','=','Perpetual Help Community Cooperative (PHCCI)')->get()->toArray(); 
        $data = RentalDividends::get()->toArray(); 
        //     dd($data);
        return $data;
        
      
 
    }
    
    public function dividendstoreleasereportrentals(){
        
        
          // $this->currdate = $this->convertdate($r1->date1);
          //$this->currinvestment = $r1->investment1;
        
  
         Excel::create("Rental Dividends To Release Report", function($excel) {

            // Set the title
            $excel->setTitle("Rental Dividends To Release Report");

            // Chain the setters
   
            //processes data into array.
            $data = $this->getRentalsReportEntries();
                   //  dd($data);
             
            $excel->sheet("Dividends Release Report", function ($sheet) use ($data) {
                
                $sheet->setOrientation('landscape');
                
                $sheet->setColumnFormat(array(
                         'E' => '#,##0.00',
                         'I' => '#,##0.00'
                ));  
                
            
                $sheet->fromArray($data, NULL, 'A3',true);
                
            
                
                /*
                $sheet->cell('A2', function($cell)   {
                        $cell->setValue("$this->currinvestment Verified Entries"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                
                $sheet->cell('A3', function($cell)   {
                        $cell->setValue("Date"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                $sheet->cell('B3', function($cell)   {
                        $cell->setValue("Investment Type"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                
                $sheet->cell('C3', function($cell)   {
                        $cell->setValue("Amount"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });    
                    
                $sheet->cell('D3', function($cell)   {
                        $cell->setValue("Email"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('E3', function($cell)   {
                        $cell->setValue("Requested By"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('F3', function($cell)   {
                        $cell->setValue("Status"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                $sheet->cell('G3', function($cell)   {
                        $cell->setValue("Remarks"); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });   
                    
                */
                    
                    
            });

        })->download('xlsx');
        
    }
   
   
}
