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



class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2($excel,$data,$title){
        
        $excel->sheet($title, function($sheet) use ($data)
        {
    
        });
    
    }
    
    public function create1($excel,$data,$title,$header,$banner,$range,$numberColumn){
        //daily_total
         $excel->sheet($title, function($sheet) use ($data,$header,$banner,$range,$numberColumn)
            {
                
                if ($numberColumn=="Z"){
                    $sheet->setColumnFormat(array(
                        'C' => '#,##0.00',
                        'D' => '#,##0.00',
                        'E' => '#,##0.00',
                        'F' => '#,##0.00',
                    ));
                }else{
                    $sheet->setColumnFormat(array(
                        $numberColumn => '#,##0.00',
                    ));
                }
                
                if ($numberColumn=="W"){
                    $sheet->setColumnFormat(array(
                        'E' => '#,##0.00',
                        'F' => '#,##0.00',
                        'G' => '#,##0.00',
                        'H' => '#,##0.00',
                    ));
                }else{
                    $sheet->setColumnFormat(array(
                        $numberColumn => '#,##0.00',
                    ));
                }
                
                if ($numberColumn=="D2"){
                    $sheet->setColumnFormat(array(

                        'F' => '0',
 
                    ));
                } 
                
                
                $sheet->cell('B2', function($cell) use ($banner) {$cell->setValue($banner);   });
                
                $sheet->cell('B2', function($cell) {$cell->setFontSize(15);   });
                
                //Set Headers
                //$test = "headertest";
                $i=0;
                $sheet->cell('B3', function($cell) use ($header,$i) {
                    $cell->setValue($header[$i]); 
                    $cell->setFont(array(
                        'bold'       => true,
                        'size'       => '13'
                    ));
 
                });
                $i++;
                $sheet->cell('C3', function($cell) use ($header,$i)  {
                    $cell->setValue($header[$i]);  
                    $cell->setFont(array(
                        'bold'       => true,
                        'size'       => '13'
                    ));
                    
                });
                $i++;
                $sheet->cell('D3', function($cell) use ($header,$i)  {
                    $cell->setValue($header[$i]); 
                    $cell->setFont(array(
                        'bold'       => true,
                        'size'       => '13'
                    )); 
                    
                });
                $i++;
                
                if (isset($header[3])){
                    
                    $sheet->cell('E3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                if (isset($header[4])){
                    
                    $sheet->cell('F3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                
                if (isset($header[5])){
                    
                    $sheet->cell('G3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                
                if (isset($header[6])){
                    
                    $sheet->cell('H3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                
                if (isset($header[7])){
                    
                    $sheet->cell('I3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                
                if (isset($header[8])){
                    
                    $sheet->cell('J3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                
                if (isset($header[9])){
                    
                    $sheet->cell('K3', function($cell) use ($header,$i)  {
                        $cell->setValue($header[$i]); 
                        $cell->setFont(array(
                            'bold'       => true,
                            'size'       => '13'
                        )); 
                    
                    });
                    
                    
                }
                $i++;
                //Set Data in Rows
                
                if (!empty($data)) {
                        foreach ($data as $key => $value) {
                            $i= $key+4;
                            $h1 = strtolower($header[0]);
                            $h2 = strtolower($header[1]);
                            $h3 = strtolower($header[2]);
                           
                            if (isset($header[3])){
                            $h4 = strtolower($header[3]);
                            }
                            
                            if (isset($header[4])){
                            $h5 = strtolower($header[4]);
                            }
                            
                            if (isset($header[5])){
                            $h6 = strtolower($header[5]);
                            }
                          
                            $sheet->cell('B'.$i, $value->$h1); 
                            $sheet->cell('C'.$i, $value->$h2); 
                            $sheet->cell('D'.$i, $value->$h3); 
                            
                            if (isset($header[3])){
                                $sheet->cell('E'.$i, $value->$h4); 
                            }
                            
                            if (isset($header[4])){
                                $sheet->cell('F'.$i, $value->$h5); 
                            }
                            
                            if (isset($header[5])){
                                $sheet->cell('G'.$i, $value->$h6); 
                            }
                            
                            
                            if (isset($header[3])){
                                $h4 = strtolower($header[3]);
                                $sheet->cell('E'.$i, $value->$h4);
                            }
                            
                            if (isset($header[4])){
                                $h5 = strtolower($header[4]);
                                $sheet->cell('F'.$i, $value->$h5);
                            }
                            
                            if (isset($header[5])){
                                $h6 = strtolower($header[5]);
                                $sheet->cell('G'.$i, $value->$h6);
                            }
                            
                            if (isset($header[6])){
                                $h7 = strtolower($header[6]);
                                $sheet->cell('H'.$i, $value->$h7);
                            }
                            
                            if (isset($header[7])){
                                $h8 = strtolower($header[7]);
                                $sheet->cell('I'.$i, $value->$h8);
                            }
                            
                            if (isset($header[8])){
                                $h9 = strtolower($header[8]);
                                $sheet->cell('J'.$i, $value->$h9);
                            }
                            
                            if (isset($header[9])){
                                $h10 = strtolower($header[9]);
                                $sheet->cell('K'.$i, $value->$h10);
                            }
                            
                        }
                }
                
                
                 $sheet->cell($range, function($cell){
                $cell->setBorder('thin','thin','thin','thin');
            });
            
           
});
            
    } 
    
    
    public function indexvaasdvf(){
         Excel::create('Report2016', function($excel) {

            // Set the title
            $excel->setTitle('My awesome report 2016');

            // Chain the setters
            $excel->setCreator('Me')->setCompany('Our Code World');

            $excel->setDescription('A demonstration to change the file properties');

            $data = [12,"Hey",123,4234,5632435,"Nope",345,345,345,345];

            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A3');
            });

        })->download('xlsx');
        //dd($data3);
    }
    
    public function second(){
        return Excel::create('sri_reportOrg', function($excel) {
            
            $data = DB::table('transactionsorg1')->orderBy('user_id','asc')->orderBy('date_transaction','asc')->get()->toArray();
            $header = array('date_transaction2','requested_by','email','dividend_payout','contribution_payout','amount','sri_balance','investment_type','status','remarks');
            $banner = 'Org Report';
            $title = "org_report_title";
            $range= 'B2:K'. (count($data)+4);
            $this->create1($excel,$data,$title, $header,$banner,$range,"W");
            
            
        })->download("xlsx");
    }
    
    
    public function userlist1(){
           
           return Excel::create('investor_list', function($excel) {
            $data = DB::table('userlist1')->get()->toArray();
            $header = array('last_name','first_name','middle_name','user_email','phone_no');
            $banner = 'Investor List';
            $title = "Investor List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D2");
            
           })->download("xlsx");
        
        
        
    }
    
    public function orglist1(){
           
           return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglist1')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");
        
        
        
    }
    
     public function orglist2(){
           
           return Excel::create('org_list_2', function($excel) {
            $data = DB::table('orglist2')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");
        
        
        
    }
    
    public function orglist2b(){

    }
    
    public function orglistphcci(){
           return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistphcci')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistdccco(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistdccco')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistsamulco(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistsamulco')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistbcc(){
         return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistbcc')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistnovadeci(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistnovadeci')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
      public function orglistmarzan1(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistmarzan1')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
     public function orglistooi(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistooi')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistbcs(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistbcs')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    
    public function orglistaski(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistaski')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistlkbp(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistlkbp')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistmaddela1(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistmaddela1')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    
    
    public function orglistmarzan2(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistmarzan2')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    
    public function orglistpmpc(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistpmpc')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
     public function orglistnico(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistnico')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    
    
     public function orglistshsc(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistshsc')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    
    public function orglistuspd(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistuspd')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function orglistnscc(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistnscc')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
 
    
    public function orglisttagum(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglisttagum')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    
     public function orglistpccc(){
        return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistpccc')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }
    
    public function index1412341(){
    //$spreadsheet = new Spreadsheet();
    //$sheet = $spreadsheet->getActiveSheet();
//$sheet->setCellValue('A1', 'Hello World !');

//$writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');
            return Excel::create('org_list_1', function($excel) {
            $data = DB::table('orglistbcc')->get()->toArray();
            $header = array('date_transaction','requested_by','email','amount','investment_type','remarks','status');
            $banner = 'Org List';
            $title = "Org List";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
           })->download("xlsx");

    }

    public function index(){
        
         
        //dd($data);
        return Excel::create('sri_report2', function($excel) {
            
            $data = DB::table('rep1')->get()->toArray();
            $header = array('date_transaction','count','sum');
            $banner = 'Daily Total with Unique Investor Count';
            $title = "daily_total";
            $range= 'B2:D'. (count($data)+3);
            $this->create1($excel,$data,$title, $header,$banner,$range,"D");
            
            $data2 = DB::table('rep2')->get()->toArray();
            $header = array('year','count','sum');
            $banner = 'Yearly Total with Unique Investor Count';
            $title = "yearly_total";
             $range= 'B2:D' . (count($data2)+3);
            $this->create1($excel,$data2,$title, $header,$banner,$range,"D");
            
            $data3 = DB::table('rep3')->get()->toArray();
            $header = array('investment_type','sum','year');
            $banner = "Total For Each Org";
            $title = "per_org_total";
             $range= 'B2:D' . (count($data3)+3);
            $this->create1($excel,$data3,$title,$header,$banner,$range,"C");
            
            $data4 = DB::table('rep4')->get()->toArray();
            $header = array('month','year','count','sum');
            $banner = "Monthly Total with Unique Investor Count";
            $title = "monthly_total";
             $range= 'B2:E' . (count($data4)+3);
            $this->create1($excel,$data4,$title,$header,$banner,$range,"E");
           
            $data5a= DB::table('rep7')->get()->toArray();
            $data5b = DB::table('rep8')->get()->toArray();
            $item1 = $data5a[0]->sum;
            $item2 = $data5b[0]->sum;
            $data5 = DB::table('rep6')->get()->toArray();
        
            $data5[0]->sri_balance = $item1 - $data5[0]->wallet_balance;
            $data5[1]->sri_balance = $item2 - $data5[1]->wallet_balance;
            //Date	Total dividend payout	Total contribution payout	Total SRI balance	Total wallet balance
            
            /*
            $header = array('date','dividend_payout_total','contribution_payout_total','wallet_balance','sri_balance');
            $banner = "Dividend Payout and Contribution Payout Total";
            $title = "payout_total";
             $range= 'B2:F5';
            $this->create1($excel,$data5,$title,$header,$banner,$range,"Z"  );
            */
            //dd($data5);
        })->download("xlsx");
    }
    
    public function index3(){
      $transactions = TransactionSync::where([
            ["file_name","LIKE","%scontent%"]


        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orderBy('id', 'desc')->get();
        
        //->orderBy('id', 'desc')->get();
        
        $i = 1;
        foreach ($transactions as $item){
            //var_dump($item);   
            
            $contents = file_get_contents($item->file_name);
            $extension = ".jpg";
            $fileFirstPart = $item->user_id;
            $filename = $fileFirstPart . "_" . time() ."_". $i . $extension;
            //$item->notes = $sriDepositPicture;
                        
            Storage::disk('public')->put($filename, $contents);
            $item->file_name = asset('storage/'.$filename);
            $item->save();
            
        
            
            $transactions2 = Transaction::where([
                 ["sync_id","=",$item->id]

            ])->get();
            
            foreach ($transactions2 as $item2){
                
                $item2->file_name = $item->file_name;
                $item2->save();
            }
            
            $i++;
        }
        
        echo "Success";
    } 
     
    public function index2(){
        //copy('', $tempImage);
     
        // Load the file contents into a variable.
        $contents = file_get_contents('https://scontent.xx.fbcdn.net/v/t1.15752-9/116788784_786689328803640_7843154549612068861_n.jpg?_nc_cat=102&_nc_sid=b96e70&_nc_ohc=Qd3bqhI_VeYAX8TLDpC&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=844d65ce374abd5d7acfef7a79d36214&oe=5F4E69F7');
        
        // Save the variable as `google.html` file onto
        // your local drive, most probably at `your_laravel_project/storage/app/` 
        // path (as per default Laravel storage config)
        Storage::disk('public')->put('file3a', $contents);
        
        
        //Storage::put('file3', $contents);
        //echo asset('storage/file1');
        $testing = "file3a";
        echo "<a href=" . asset('storage/' . $testing) . ">" .asset('storage/'. $testing) . "</a>";
        echo "<BR>";
        echo $url = env('APP_URL'). Storage::url('file3a');
        echo $url =  Storage::url('file3a') . "<BR>";
        echo "<a href=" . Storage::url('file3a') . ">" .Storage::url('file3a') . "</a>";
        echo "<BR>";
        echo url()->current();
        echo "<BR>";
          echo url('file3a');
        
          echo "<BR>";
          echo url(Storage::url('file3a'));
           echo "<BR>";
           echo "<a href=" . url(Storage::url('file3a')) . ">" .url(Storage::url('file3a')) . "</a>";
           
           echo "<BR>";
                echo "<a href=" . asset('file3a') . ">" .asset('file3a') . "</a>";
        echo "<BR>";
    }
    
    public function createExcel(){
        Excel::create('Report2016', function($excel) {

            // Set the title
            $excel->setTitle('My awesome report 2016');

            // Chain the setters
            $excel->setCreator('Me')->setCompany('Our Code World');

            $excel->setDescription('A demonstration to change the file properties');

            $data = [12,"Hey",123,4234,5632435,"Nope",345,345,345,345];

            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A3');
            });

        })->download('xlsx');
        
    }
    
   
    
   
    
   
   
}
