<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Response;
use App\Mail\verifyMail;
 
 
use App\UserO;
use App\Transaction;

use App\Monthly;
use App\MonthlyTotal;
use App\Yearly;
use App\YearlyTotal;

class ReportController2 extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
    public $out = array(); 
     
    public function __construct()
    {
        //$this->middleware('auth',['except' => ['testSend','testLoad','testRe']]);
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }
    
    public function queryMonthly($org){
        
    
        if ($org == "SEDPI"){

            $monthly = Monthly::where([])
            ->whereIn('investment_type',array("SEDPI","Class B","Class D","Class E"))->get();

        } else {
            
            $monthly = Monthly::where([
            ["investment_type","=",$org]
            ])->get();
            
        }
        
        $data = array();
        $count = array();
        
        if ($org == "SEDPI"){
            foreach ($monthly as $item){
           
                if (!isset($data[$item->year][$item->month])){
                    $data[$item->year][$item->month] = $item->amount; 
                    $count[$item->year][$item->month] = $item->count; 
                
                }else{
                    $data[$item->year][$item->month] += $item->amount; 
                    $count[$item->year][$item->month] += $item->count; 
                    
                }        
            }
        } else {
            foreach ($monthly as $item){
               
                    $data[$item->year][$item->month] = $item->amount; 
                    $count[$item->year][$item->month] = $item->count; 
            }
        } 
     
        return array($data,$count,$org);   
    }
    
    
      public function queryYearly($org){
        
        if ($org == "SEDPI"){

            $yearly = Yearly::where([])
            ->whereIn('investment_type',array("SEDPI","Class B","Class D","Class E"))->get();

        } else {
            
            $yearly = Yearly::where([
            ["investment_type","=",$org]
            ])->get();
            
        }
      
        $data = array();
        $count = array();
        
        if ($org == "SEDPI"){
            foreach ($yearly as $item){
           
                if (!isset($data[$item->year])){
                    $data[$item->year] = $item->amount; 
                    $count[$item->year] = $item->count; 
                
                }else{
                    $data[$item->year] += $item->amount; 
                    $count[$item->year] += $item->count; 
                    
                }        
            }
        } else {
            foreach ($yearly as $item){
               
                    $data[$item->year] = $item->amount; 
                    $count[$item->year] = $item->count; 
            }
        } 
     
        return array($data,$count,$org);   
    }
    
    
    
    
     public function queryMonthlyTotal(){
        
        $monthly = MonthlyTotal::where([
            
            ])->get();
    
    
        $data = array();
        $count = array();
        
        $growth = array();
        $growthCount = array();
        
        $prev = 0;
        $prevCount = 0;
        
        $i = 0;
        
        foreach ($monthly as $item){
           
                $data[$item->year][$item->month] = $item->amount; 
                $count[$item->year][$item->month] = $item->count; 
                
                if ($i == 0){
                    //initialize at first iteration
                    $growth[$item->year][$item->month] =  0;
                    $prev = $item->amount; 
                    $growthCount[$item->year][$item->month] =  0;
                    $prevCount = $item->count; 
                    
                } else {
                    $growth[$item->year][$item->month] = ($item->amount - $prev) / $prev;
                    $growthCount[$item->year][$item->month] = ($item->count - $prevCount) / $prevCount;
                    
                    //for the next iteration
                    $prev = $item->amount; 
                    $prevCount = $item->count; 
                }
                
            $i++;
                
        }
     
        $org = "Total";
        
        return array($data,$count,$org,$growth,$growthCount);   
    }
    
    public function queryYearlyTotal(){
        
        $yearly = YearlyTotal::where([
 
            
            ])->orderBy('year', 'asc')
              ->get();
    
    
        $data = array();
        $count = array();
        $growth = array();
        $growthCount = array();
        
        $prev = 0;
        $prevCount = 0;
        
        $i = 0;
        foreach ($yearly as $item){
         
           
                $data[$item->year] = $item->amount; 
                $count[$item->year] = $item->count; 
            
                if ($i == 0){
                    //initialize at first iteration
                    $growth[$item->year] =  0;
                    $prev = $item->amount; 
                    $growthCount[$item->year] =  0;
                    $prevCount = $item->count; 
                    
                } else {
                    $growth[$item->year] = ($item->amount - $prev) / $prev;
                    $growthCount[$item->year] = ($item->count - $prevCount) / $prevCount;
                    
                    //for the next iteration
                    $prev = $item->amount; 
                    $prevCount = $item->count; 
                }
                
            $i++;
        }
     
        $org = "Total";
        
        return array($data,$count,$org,$growth,$growthCount);   
    }
    
    public function setMonth($item){
        $month = "";
        
        switch($item){
            
            case 1:
                $month = "January";
                break;
            case 2:
                $month = "February";
                break;
            case 3:
                $month = "March";
                break;
            case 4:
                $month = "April";
                break;
            case 5:
                $month = "May";
                break;
            case 6:
                $month = "June";
                break;
            case 7:
                $month = "July";
                break;
            case 8:
                $month = "August";
                break;
            case 9:
                $month = "Semptember";
                break;
            case 10:
                $month = "October";
                break;
            case 11:
                $month = "November";
                break;
            case 12:
                $month = "December";
                break;
            
        }
        
        return $month;
    }
    
    public function displayHeader(){
        $startdate = array(8,2019); 
        
        //try today's timestamp
        $month = date('n');
        $year = date('Y');
        $enddate = array($month,$year); 
        
        $temp = array();
        $temp[] = "Org";
        
        //create a monthly loop
        for ($i=$startdate[1];$i<$enddate[1]+1;$i++){
            for ($j=1;$j<13;$j++){
            
                if ($j<$startdate[0] && $i==$startdate[1] ){
                  
                }else if($j>$enddate[0] && $i==$enddate[1] ){
       
                }else{
                     //echo $this->setMonth($j) . ",";
                     //echo "$i,";
                     $temp[] = $this->setMonth($j) . "";
                     $temp[] = "$i";
                }
            
            } //end for j
        } //end for i
         
        $this->out[] = $temp;
         
    }
    
    public function displayYearlyHeader(){
        $startdate = array(2,2011); 
        //try today's timestamp
         
        $month = date('n');
        $year = date('Y');
         
        $enddate = array($month,$year); 
        
        $temp = array();
        $temp[] = "Org";
         
        //create a monthly loop
        for ($i=$startdate[1];$i<$enddate[1]+1;$i++){
           
                     //echo "$i,";
                     //echo ",";
                     $temp[] = $i;
                     $temp[] = " ";
        }
         
        $this->out[] = $temp;
    } 
    
    
    public function displayMonthly($input){
        
        $temp = array();
        $temp2 = array();
        
        $data = $input[0];
        $count = $input[1];
         
        //$org = (!isset($input[2])) ? "Total" : $input[2];
        $org = $input[2];
        
        $startdate = array(8,2019); 
        
        //try today's timestamp
        $month = date('n');
        $year = date('Y');
        
        $enddate = array($month,$year); 
        
        if(isset($input[3])){
            //echo  "MoM growth,";   
            $temp2[] = "MoM growth";   
            $growth = $input[3];
            $growthCount = $input[4];
            $counter = 0;
        }
         
        $temp[] = "$org";
        
        for ($i=$startdate[1];$i<$enddate[1]+1;$i++){
            for ($j=1;$j<13;$j++){
            
                if ($j<$startdate[0] && $i==$startdate[1] ){
       
                }else if($j>$enddate[0] && $i==$enddate[1] ){
                     
                }else{
                    
                    if (!isset($data[$i][$j])){
                        //echo "-" . ",";
                        //echo "-" . ",";
                        $temp[] = "-" . "";
                        $temp[] = "-" . "";
                        
                    } else {
                        //echo $data[$i][$j] . ",";
                        //echo $count[$i][$j] . ",";
                        $temp[] = $data[$i][$j] . "";
                        $temp[] = $count[$i][$j] . "";
                        
                    }
                    
                    if(isset($input[3])){
                    
                        if (!isset($growth[$i][$j])){
                                // echo "-" . ",";
                                // echo "-" . ",";
                                $temp2[] = "-" . "";
                                $temp2[] = "-" . "";
                        } else {
                                $percent1 = round((float)$growth[$i][$j] * 100 ) . '%';
                                $percent2 = round((float)$growthCount[$i][$j] * 100 ) . '%';
                                
                                if ($counter == 0){
                                    //echo 0 . ",";
                                    //echo 0 . ",";
                                    $temp2[] =  0 . "";
                                    $temp2[] =  0 . "";
                                    $counter++; 
                                } else {
                                    // echo $percent1 . ",";
                                    //echo $percent2 . ",";
                                    $temp2[] = $percent1 . "";
                                    $temp2[] = $percent2 . "";
                                }

                        }// end if growth    
                             
                    }//end isset
         
                } // end else
            
            } //end for j
        
        } //end for i
           
        $this->out[] = $temp;
        
        if(isset($input[3])){
            $this->out[] = $temp2;
        }
    }
    
    public function displayYearly($input){
        
        $temp = array();
        $temp2 = array();
        
        $data = $input[0];
        $count = $input[1];
        //$org = (!isset($input[2])) ? "Total" : $input[2];
        $org = $input[2];
        
        $startdate = array(2,2011); 
        //try today's timestamp
        $month = date('n');
        $year = date('Y');
         
        $enddate = array($month,$year); 
         
        //echo  "$org,";
        $temp[] = "$org";
        
        if(isset($input[3])){
            $temp2[] = "MoM growth"; 
            // echo  "MoM growth,";    
            $growth = $input[3];
            $growthCount = $input[4];
            $counter = 0;
        }
        
        for ($i=$startdate[1];$i<$enddate[1]+1;$i++){
                    if (!isset($data[$i])){
                        //echo "-" . ",";
                        //echo "-" . ",";
                        $temp[] = "-" . "";
                        $temp[] = "-" . "";
                    } else {
                        //echo $data[$i] . ",";
                        //echo $count[$i] . ",";
                        $temp[] = $data[$i] . "";
                        $temp[] = $count[$i] . "";
                    }
                    
                    if(isset($input[3])){
              
                        if (!isset($growth[$i])){
                            //echo "-" . ",";
                            //echo "-" . ",";
                            $temp2[] = "-" . "";
                            $temp2[] = "-" . "";
                        } else {
                            $percent1 = round((float)$growth[$i] * 100 ) . '%';
                            $percent2 = round((float)$growthCount[$i] * 100 ) . '%';
                            if ($counter == 0){
                                //echo 0 . ",";
                                //echo 0 . ",";
                                $temp2[] = 0;
                                $temp2[] = 0;
                                $counter++;
                                 
                            }else {
                                //echo $percent1 . ",";
                                //echo $percent2 . ",";
                                $temp2[] = $percent1;
                                $temp2[] = $percent2;
                            }
                             
                        } //end else

                    } // end isset
        } // end for
        
        $this->out[] = $temp;
        
        if(isset($input[3])){
            $this->out[] = $temp2;
        }
        
    }
    
    public function summary(){
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',   
            'Content-type'        => 'text/csv',   
            'Content-Disposition' => 'attachment; filename=report.csv',   
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];
    
        $this->summaryMonthly();
    
        //$list = Yearly::all()->toArray();
        // add headers for each column in the CSV download
        // array_unshift($list, array_keys($list[0]));
        
        $list = $this->out;
        $callback = function() use ($list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
    
    public function summaryMonthly(){

        $orgs = array();
        $orgs[] = "Alalay Sa Kaunlaran Inc";
        $orgs[] = "NSCC";
        $orgs[] = "Pantukan Chess Club Cooperative";
        $orgs[] = "United Sugar Planters of Digos";
        $orgs[] = "Tagum Cooperative";
        $orgs[] = "Organic Options";
        $orgs[] = "SEDPI";
        $orgs[] = "MARZAN1";
        
        $month = date('F');
        $day = date('j');
        $year = date('Y');

        $enddate = array($month,$year); 
        
        $this->out[] = array("SRI Summary report");
        $this->out[] = array("$month $day, $year");
        $this->out[] = array(" ");
        $this->out[] = array("Monthly Trend");
        $this->out[] = array(" ");
        
        $this->displayHeader();
        foreach ($orgs as $org){
            $this->displayMonthly($this->queryMonthly($org));
        }
        $this->displayMonthly($this->queryMonthlyTotal());
   
        $this->summaryYearly();
    }
    
    public function summaryYearly(){
        
        $orgs = array();
        $orgs[] = "Alalay Sa Kaunlaran Inc";
        $orgs[] = "NSCC";
        $orgs[] = "Pantukan Chess Club Cooperative";
        $orgs[] = "United Sugar Planters of Digos";
        $orgs[] = "Tagum Cooperative";
        $orgs[] = "Organic Options";
        $orgs[] = "SEDPI";
        $orgs[] = "MARZAN1";
        
        $this->out[] = array(" "); 
        $this->out[] = array("Annual Trend");
        $this->out[] = array(" ");

        $this->displayYearlyHeader();
        foreach ($orgs as $org){

            $this->displayYearly($this->queryYearly($org));
            
        }
        $this->displayYearly($this->queryYearlyTotal());
        
    }
    
}
