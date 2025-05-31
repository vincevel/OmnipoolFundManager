<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\verifyMail;
use App\Mail\reinvestSuccessMail;
use App\Mail\reinvestErrorMail;
use App\Name;
use App\Reinvestment;
use App\UserO;
use App\Transaction;

class ReinvestmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        ///home/vincerap7132/sri/app/Http/Middleware/VerifyCsrfToken.php for csrf exemption
        
        //return view('home');
    }
    
    public function getEntries(){
        
        $items = Reinvestment::where([
            ['status', '=', 0 ],
            ['email_count', '=', 1 ]
        ])
        ->orderBy('id', 'desc')->get();
        
        return $items;
        
    }
    
    public function countForEmail($email){
        
        $count = UserO::where([
            ['user_email', '=', $email  ],
        ])
        ->count();
        
        return $count;
        
    }
    
    public function getUserDetails($email){
        
        $user = UserO::where([
            ['user_email', '=', $email ],
        ])
        ->orderBy('id', 'desc')->get();
        
        //Only One User
        return $user[0];
        
    }
    
    
    public function getUserWalletTransactions($user_id){
        
        $walletTransactions = Transaction::where([
            ['user_id', '=', $user_id ],
            ['investment_type', '=', "My Wallet" ],
            ['status', '=', "Verified" ],
        ])
        ->orderBy('date_transaction', 'asc')->get();
        
        //Only One User
        return $walletTransactions;
        
    }
    
    public function getWalletTotal($items){
        
        $total = 0;
        
        foreach ($items as $item){
            ($item->transaction_type_id == 3 || $item->transaction_type_id == 8 || $item->transaction_type_id == 10) ? $total -= $item->amount : $total += $item->amount;
        }
        
        $total = number_format($total, 2, '.', '');
        
        return $total;
    }
    
     public function formatOrg($org){
        
         
        $org = trim(strtoupper($org));
        $org = str_replace(' ', '', $org);
        
        switch ($org){
          
            case "OOI 2";
                return "OOI2";
                break;
            
            case "OOI2";
                return "OOI2";
                break;
            
            case "ORGANIC OPTIONS 2";
                return "OOI2";
                break;
                
            case "ORGANIC OPTIONS2";
                return "OOI2";
                break;
            
          
            case "USPD";
                return "United Sugar Planters of Digos";
                break;
            case "OOI";
                return "Organic Options";
                break;
            case "ORGANIC OPTIONS";
                return "Organic Options";
                break;
            case "SEDPI";
                return "SEDPI";
                break;
            case "ASKI";
                return "Alalay Sa Kaunlaran Inc";
                break;
            case "TC";
                return "Tagum Cooperative";
                break;
            case "NSCC";
                return "NSCC";
                break;
            case "LKBP";
                return "LKBP";
                break;
            case "BCS";
                return "BCS";
                break;
            case "NICO";
                return "NICO";
                break;
            case "PCCC";
                return "Pantukan Chess Club Cooperative";
                break;
            case "MARZAN 1";
            case "MARZAN1";
                return "MARZAN1";
                break;
                
            case "MARZAN 2";
            case "MARZAN2";
                return "MARZAN2";
                break;    
            
            
            case "MADDELA 1";
            case "MADDELA1";
                return "MADDELA1";
                break;    
            
            case "MAF 1";
            case "MAF1";
                return "MAF1";
                break;     
                
            case "SHSC";
                return "SHSC";
                break;
            case "PMPC";  
                return "PMPC";
                break;
                
            case "PHCCI";  
                return "PHCCI";
                break;
                
            case "DCCCO";  
                return "DCCCO";
                break;
                
            case "SAMULCO";  
                return "SAMULCO";
                break;
            
            case "BCC";  
                return "BCC";
                break;
                
            case "NOVADECI";  
                return "NOVADECI";
                break;
                            
            default:
                //return 0;
                return "UNKNOWN";
                break;
        }
        
       
        
    }
    
    
    public function checkOrg($org){
        
         
        $org = trim(strtoupper($org));
        $org = str_replace(' ', '', $org);
        
        switch ($org){
            
            case "OOI2";
            case "OOI 2";
            case "ORGANIC OPTIONS 2";
            case "ORGANIC OPTIONS2";
            case "USPD";
            case "OOI";
            case "SEDPI";
            case "ASKI";
            case "TC";
            case "NSCC";
            case "MAF 1";
            case "MAF1";
            case "PCCC";
            case "LKBP";
            case "NICO";
            case "NIC";
            case "MARZAN 1";
            case "MARZAN1";
            case "MARZAN 2";
            case "MARZAN2";
            case "MADDELA 1";
            case "MADDELA1";
            case "SHSC";
            case "PMPC";   
            case "PHCCI"; 
            case "DCCCO"; 
            case "SAMULCO"; 
            case "BCC"; 
            case "NOVADECI"; 
            case "BCS";
                return 1;
                break;
                
            default:
                return 0;
                break;
        }
        
       
        
    }
    
    public function checkIfBelow10k($amount){
        return ($amount < 10000) ? 1 : 0;
    }
    
    public function checkIfBelow100k($amount){
        return ($amount < 100000) ? 1 : 0;
    }
    
    public function sendErrorMail($item,$errorMsg){
        
        
        
        
        $data = array();
        
        if (trim($item->name)==NULL){
            
            //$user = $this->getUserDetails($item->email);
            $data["requested_by"] = "Investor";
        }else{
            
            $data["requested_by"] = $item->name;
        }
        
          
            //$data["requested_by"] = $item->name; 
            $data["email"] = $item->email; 
            $data["date_transaction"] = $item->transaction_date; 
            $data["amount"] = $item->amount; 
            $data["notes"] = $errorMsg; 
            $data["investment_type"] = $item->org; 
            
            $receiver = $item->email;
            //$receiver = "vincentvelasco1232019@gmail.com";
            
            $cc= array();
            
            
            $cc[] = "irmacuello18@gmail.com";
            $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "fadviento@gmail.com";
            
            
             $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new reinvestErrorMail($data));
        
    }
    
    public function sendSuccessMail($item){
           $data = array();
          
            $data["requested_by"] = $item->name; 
            $data["email"] = $item->email; 
            $data["date_transaction"] = $item->transaction_date; 
            $data["amount"] = $item->amount; 
            //$data["notes"] = $item->notes; 
            $data["investment_type"] = $item->org; 
            
            $receiver = $item->email;
            //$receiver = "vincentvelasco1232019@gmail.com";
            
            $cc= array();
            
            
            $cc[] = "irmacuello18@gmail.com";
            $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "fadviento@gmail.com";
            
            
             $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new reinvestSuccessMail($data));
    }
    
    public function setAmount($amount,$org){
        $org = strtoupper($org);
        $org = str_replace(' ', '', $org);
        
        if ($org == "MARZAN1" || $org == "MARZAN2" || $org == "MADDELA1" ){
            
            if($amount % 100000 == 0){
                return $amount;
            } else {
                $temp = intval($amount / 100000);
                return $temp * 100000;
            }

        }else{
            
            if($amount % 10000 == 0){
                return $amount;
            } else {
                $temp = intval($amount / 10000);
                return $temp * 10000;
            }
            
        }

    }
    
    public function processReinvestments(){
    
        $count = Reinvestment::where([
            ['status', '=', 0 ],
            ['email_count', '=', 1 ]
        ])
        ->count();
        
        if ($count > 0){
            
            $this->processReinvestments2();
            
        }
        //return $count;
    
   
        
    }
    
    
    public function processReinvestments2(){
        
        $output = array();
        
        $error = false;
        $errorMsg = array();
        
        //1. Query all unprocessed 0 single email entries 
        $items = $this->getEntries();
 
        foreach ($items as $item){
            
                $isBelow10k = $this->checkIfBelow10k($item->amount);  
                $isBelow100k = false;
                
                if ($isBelow10k){
                    $error = true;
                    $errorMsg[] = "The amount requested is below Php10000";
                }
                
                $isOrgValid = $this->checkOrg($item->org);
                
                $forg = $this->formatOrg($item->org);
                
                if ($forg == "MARZAN1"  ){
                    $isBelow100k = $this->checkIfBelow100k($item->amount);  
                
                    if ($isBelow100k){
                        $error = true;
                        $errorMsg[] = "The amount requested is below Php100,000";
                    }
                
                }
                
                if ($forg == "MADDELA1"){
                    $isBelow100k = $this->checkIfBelow100k($item->amount);  
                
                    if ($isBelow100k){
                        $error = true;
                        $errorMsg[] = "The amount requested is below Php100,000";
                    }
                
                }
                
               if ($forg == "MARZAN2"){
                    $isBelow100k = $this->checkIfBelow100k($item->amount);  
                
                    if ($isBelow100k){
                        $error = true;
                        $errorMsg[] = "The amount requested is below Php100,000";
                    }
                
                }
                
                
                if (!$isOrgValid){
                    $error = true;
                    $errorMsg[] = "The org - $item->org - indicated is invalid";
                }
                
                if (strtoupper($item->org) == "OOI"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "Organic Options (OOI) joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "NSCC"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "NSCC joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "TC"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "Tagum Coop joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "DELMARZAN 1"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "MARZAN 1 is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "DELMADDELA 1"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "MARZAN 1 is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "SEDPI"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "SEDPI is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "LKBP"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "LKBP joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if (strtoupper($item->org) == "USPD"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "USPD joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                }
                
                if ($forg == "BCS"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "BCS joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                
                }
                
                if ($forg == "PCCC"){
                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "PCCC joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                
                }
                
                /*
                case "OOI2";
                case "OOI 2";
                case "ORGANIC OPTIONS 2";
                case "ORGANIC OPTIONS2";
                */
                

                
                
                if (strtoupper($item->org) == "OOI2"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "OOI2"  ],
                    ])->whereIn('status',array('Pending','Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "3200000.00"){
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "Organic Options 2 (OOI2) joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    }
                }
                
                if (strtoupper($item->org) == "OOI 2"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "OOI2"  ],
                    ])->whereIn('status',array('Pending','Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "3200000.00"){
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "Organic Options 2 (OOI2) joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    }
                }
                
                if (strtoupper($item->org) == "ORGANIC OPTIONS 2"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "OOI2"  ],
                    ])->whereIn('status',array('Pending','Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "3200000.00"){
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "Organic Options 2 (OOI2) joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    }
                }
                
                if (strtoupper($item->org) == "ORGANIC OPTIONS2"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "OOI2"  ],
                    ])->whereIn('status',array('Pending','Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "3200000.00"){
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "Organic Options 2 (OOI2) joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    }
                }
                
                if ($forg == "MAF1"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MAF1"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1400000.00"){
                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "MAF1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1400000.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "MAF1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                if ($forg == "Alalay Sa Kaunlaran Inc"){

                    $isOrgValid = 0;
                    $error = true;
                    $errorMsg[] = "Alalay Sa Kaunlaran Inc joint venture is already full. Kindly choose another SRI organization or in your wallet.";

                }


                //1
                
                if ($forg == "PHCCI"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "PHCCI"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1500000.00"){
                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "PHCCI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1500000.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "PHCCI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                //2
                
                if ($forg == "DCCCO"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "DCCCO"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1000000.00"){
                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "DCCCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1000000.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "DCCCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                //3
                
                if ($forg == "SAMULCO"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "SAMULCO"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1500000.00"){
                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "SAMULCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1500000.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "SAMULCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                //4
                
                if ($forg == "BCC"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "BCC"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1000000.00"){
                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "BCC joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1000000.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "BCC joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                
                if ($isOrgValid && !$isBelow100k){
                //5-1
                
                if ($forg == "MARZAN1"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MARZAN1"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "14570493.00"){                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "MARZAN1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 14570493.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "MARZAN1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                //5-12
                
                if ($forg == "MARZAN2"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MARZAN2"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "15800000.00"){                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "MARZAN2 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 15800000.00 ){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "MARZAN2 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                //5-2
                
                if ($forg == "MADDELA1"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MADDELA1"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "6725460.42"){                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "MADDELA1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 6725460.42){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "MADDELA1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                } //end check for error
                
                //5
                
                if ($forg == "NOVADECI"){
                    
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "NOVADECI"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1000000.00"){
                        //OVER THE LIMIT
                        
                        $isOrgValid = 0;
                        $error = true;
                        $errorMsg[] = "NOVADECI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                    } else {
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $this->setAmount($item->amount,$item->org);
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1000000.00){
                            $isOrgValid = 0;
                            $error = true;
                            $errorMsg[] = "NOVADECI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            
                        }
                        
                    }
                } // end IF
                
                //6
         
                $isBelow = false;
                
                if ($isBelow10k || $isBelow100k){
                    $isBelow = true;
                }
                
                // public function countForEmail($email){
                
                $userCount = $this->countForEmail($item->email);
                if ($userCount > 1){
                    $isBelow = true;
                }
                
                
                if ($isOrgValid && !$isBelow){
                    $user = $this->getUserDetails($item->email);
                    $walletTransactions = $this->getUserWalletTransactions($user->id);
                    $walletTransactionsTotal = $this->getWalletTotal($walletTransactions);
                    
                    //round off amount to 10k if normal 
                    //round off amount to 100k if marzan
                    $item->amount = $this->setAmount($item->amount,$item->org);
                    
                    $iamount = number_format($item->amount, 2, '.', '');
                    
                    if($walletTransactionsTotal >= $iamount){
                        //SUCCESS CASE
                        //create transaction items in wallet and target org
                        
                        //CORRECT ORG
                        $org  = $this->formatOrg($item->org);
                        
                        if (!$org == 0){ // might be unnecessary keep it for now
                            $this->storeReinvest($user,$item,$org);
                            $this->sendSuccessMail($item);
                            $item->status = 1;
                            
                            //if ( $daysdiff < 0 ){
                             //   $item->date_transaction = $holder;
                            //}     
                            
                            $item->save();
                        } 
                       
                    }else{
                         //ERROR CASE
                        $error = true;
                        //$walletTransactionsTotal - $iamount
                        $errorMsg[] = "Your wallet does not have enough funds. If you have deposited money to My Wallet, please make sure that your deposit is Verified before you Re-Invest.";
                        
                    }// end wallet and amount comparison
                    
                }  //end checks for org and below 10k
                        
                //check if error is true and send fail mail
                if ($error){
                    $this->sendErrorMail($item,$errorMsg);
                    
                    //save status to indicate row has been processed
                    $item->status = 1;
                    
                    
                    
                    $item->save();
                }
                
                //reset error variables
                $error = false;
                $errorMsg[] = array();
        } //end for loop
        

    }
    
    public function checkAboveLimit($org)
    {
      
        
    }
    
    public function storeReinvest($user,$request,$org)
    {
                        
        
        
             //Wallet Transaction
                        $transaction2 = new Transaction;
                        $transaction2->last_name = $user->last_name;
                        $transaction2->first_name = $user->first_name;

                        $transaction2->user_id = $user->id;
                        $transaction2->account_id = $user->account_id;
                        $transaction2->email = $user->user_email;

                        $date = "";
                        // 2021-01-21
                        $date2 = $request->transaction_date;
                        
	                    $tdate = date('Y-m-d'); 
	                    $sdate4 = date_create($date2);
	                    $edate4 = date_create($tdate);
                        $diff = date_diff($edate4,$sdate4); 
                        $daysdiff = $diff->format("%R%a");
                        
                        
                        if ( $daysdiff < 0 ){
                            $transaction2->date_transaction = $tdate;
                            
                        } else {
                            $transaction2->date_transaction = $date2;
                        }
                        
                        //$transaction2->date_transaction = $date2;

                        $transaction2->status = "Verified";
  
                        $transaction2->investment_type = "My Wallet";
                       
                        $transaction2->transaction_type_id = 8;
                        $transaction2->remarks = "Reinvested to $org";

                        $transaction2->amount = $request->amount;
                        $transaction2->running_balance = $request->amount;
 
              
                        $transaction2->is_posted = 8;
                        $transaction2->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction2->save();
                        
                        
                        //ORG Transaction
                        $transaction1 = new Transaction;
                        $transaction1->last_name = $user->last_name;
                        $transaction1->first_name = $user->first_name;
         
                        $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        
                        if ( $daysdiff < 0 ){
                            $transaction1->date_transaction = $tdate;
                        } else {
                            $transaction1->date_transaction = $date2;
                        }
                        
                        //$transaction1->date_transaction = $date2;
                        
                        $transaction1->status = "Verified";
 
 
                       
                        $transaction1->investment_type = $org;
                       
                        $transaction1->transaction_type_id = 9;
                        $transaction1->remarks = "Reinvestment";

 
                        $transaction1->amount =  $request->amount;
                        $transaction1->running_balance = $request->amount;
              
                        $transaction1->is_posted = 8;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                       
                         
                        $transaction1->save();
                       
                
  
    }
    
   
}
