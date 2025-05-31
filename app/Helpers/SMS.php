<?php 
namespace App\Helpers;

use App\Helpers\PayoutUpdater;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\User;
class SMS{
    private static function formatMoney($amount){
        return "$".number_format($amount,2);
    }
    public static function sendAutoDeferNotification($payout){
        $payouts = Payout::where([
            ['user_id', '=', $payout->user_id ]
        ])->orderBy('date','DESC')
        ->limit(2)->get();

        $user = User::where([
            ['id', '=', $payout->user_id ]
       ])->first();
        $currentBalance=self::formatMoney($payouts[0]->running_balance);
        $thisMonthPayout=self::formatMoney($payouts[1]->amount);
        $nextMonthPayout=self::formatMoney($payouts[0]->amount);
        $amountToNextTier=self::formatMoney(PayoutUpdater::getAmountToNextTier($payouts[0]->running_balance));
        $to=$user->phone_number;
        $firstName=ucwords($user->first_name); 
        $currentTier=PayoutUpdater::getCurrentTier($payouts[0]->running_balance);

        switch($currentTier){
            case "Pre Entry":
                SMS::deferPayoutPreEntry($firstName,$currentBalance,$nextMonthPayout,$amountToNextTier,$to);
                break;
            case "Entry Status":
                SMS::deferPayoutEntry($firstName,$currentBalance,$nextMonthPayout,$amountToNextTier,$to);
                break;
            default:
                SMS::deferPayoutTierX($firstName,$currentBalance,$nextMonthPayout,$amountToNextTier,$to);
        }
            
        
        
        
    }
    
    public static function sendDisperseNotification($tx){
        if($tx->transaction_type_id!=7) return;
        $payouts = Payout::where([
            ['user_id', '=', $tx->user_id ]
        ])->orderBy('date','DESC')
        ->limit(2)->get();

        $user = User::where([
            ['id', '=', $tx->user_id ]
       ])->first();
       
        self::dispersePayout(
            ucwords($user->first_name),
            self::formatMoney($tx->amount),
            $user->bitcoin_address,
            self::formatMoney($payouts[0]->amount),
            self::formatMoney($payouts[0]->running_balance),
            self::formatMoney(PayoutUpdater::getAmountToNextTier($payouts[0]->running_balance)),
            $user->phone_number);
    }
    public static function sendTierChangeMessage($tx){
        
        $payouts = Payout::where([
            ['user_id', '=', $tx->user_id ]
       ])->orderBy('date','DESC')
       ->limit(2)->get();

       $transaction=Transaction::where([
            ['user_id','=',$tx->user_id],
            ['transaction_type_id','!=',7]
       ])->orderBy('date_transaction','DESC')->first();
        

       if($transaction->transaction_type_id==4){
         $transaction->amount=(-$transaction->amount);
       }
       
       
       if(in_array($transaction->transaction_type_id,array(1,3,4,5))){
            $currentTier=PayoutUpdater::getCurrentTier($payouts[0]->running_balance);
            $prevTier=PayoutUpdater::getCurrentTier($payouts[0]->running_balance-$transaction->amount);
            $user = User::where([
                ['id', '=', $tx->user_id ]
           ])->first();

           $currentBalance=self::formatMoney($payouts[0]->running_balance);
           $thisMonthPayout=self::formatMoney($payouts[1]->amount);
           $nextMonthPayout=self::formatMoney($payouts[0]->amount);
           $amountToNextTier=PayoutUpdater::getAmountToNextTier($payouts[0]->running_balance);
           $to=$user->phone_number;
           $btcAddress=$user->bitcoin_address; 
           $isDeferred= $payouts[1]->isDeferred?true:false;        
            switch($currentTier){
                case "Pre Entry":
                    if($tx->transaction_type_id==1){
                        if($isDeferred){
                            self::newDepositPreEntryDefer(
                                $currentBalance,
                                $thisMonthPayout,
                                $nextMonthPayout,
                                $amountToNextTier,
                                $to);
                        }else{
                            self::newDepositPreEntryPayout(
                                $currentBalance,
                                $thisMonthPayout,
                                $btcAddress,
                                $nextMonthPayout,
                                $amountToNextTier,
                                $to);
                        } 
                    }
                    
                    break;
                case "Entry Status":
                    if(($currentTier!=$prevTier)){
                        self::hitEntryStatus(
                            ucwords($user->first_name),
                            self::formatMoney($payouts[0]->running_balance),
                            self::formatMoney($payouts[1]->amount),
                            self::formatMoney($payouts[0]->amount),
                            self::formatMoney($amountToNextTier),
                            $user->phone_number
                        );
                    }
                    if($tx->transaction_type_id==1){
                        if($isDeferred){
                            self::newDepositEntryDefer(
                                $currentBalance,
                                $thisMonthPayout,
                                $nextMonthPayout,
                                $amountToNextTier,
                                $to);
                        }
                        else{
                            self::newDepositEntryPayout(
                                $currentBalance,
                                $thisMonthPayout,
                                $btcAddress,
                                $nextMonthPayout,
                                $amountToNextTier,
                                $to);
                        }
                    }
                    
                    
                    break;
                default:
                    if(($currentTier!=$prevTier)){
                        if($currentTier=="Tier 1"){
                            self::hitTier1(ucwords($user->first_name),
                            self::formatMoney($payouts[0]->running_balance),
                            self::formatMoney($payouts[1]->amount),
                            self::formatMoney($payouts[0]->amount),
                            self::formatMoney($amountToNextTier),
                            $user->phone_number);
                        }else{
                            self::hitTierX(ucwords($user->first_name),
                            self::formatMoney($payouts[0]->running_balance),
                            self::formatMoney($payouts[1]->amount),
                            self::formatMoney($payouts[0]->amount),
                            self::formatMoney($amountToNextTier),
                            $user->phone_number);
                        }
                        
                    }
                    if($tx->transaction_type_id==1){
                        if($isDeferred){
                            self::newDepositTierXDefer(
                                $currentBalance,
                                $thisMonthPayout,
                                $nextMonthPayout,
                                $amountToNextTier,
                                $to);
                        }
                        else{
                            self::newDepositTierXPayout(
                                $currentBalance,
                                $thisMonthPayout,
                                $btcAddress,
                                $nextMonthPayout,
                                $amountToNextTier,
                                $to);
                        }
                    }
                    
                    
                    
            }
            
       }

       
       //1,3,5 Add
       //4 Withdraw
    }
    public static function deferStatusChanged(
        $name,
        $month,
        $isdeferred
    ){
        self::sendSms('A user('.$name.') has changed '.$month.'\'s payout status from '.self::getDeferredName($isdeferred).' to '.self::getDeferredName($isdeferred==1?0:1));
    }
    private static function getDeferredName($isdeferred){
        if($isdeferred==1){
            return "Deferred";
        }else{
            return "Payout";
        }
    }
    public static function bitcoinAddressChanged(
        $name,
        $old,
        $new
    ){
        self::sendSms('A user('.$name.') has changed their bitcoin address from '.$old.' to '.$new);
    }

    public static function dispersePayout($firstName,$deferAmount,$btcAddress,$nextMonthPayout,$currentBalance,$amountToNextTier,$to){
        self::sendSms('Hey '.$firstName.'! Very excited to be sending you your payout of '.$deferAmount.' to the BTC Address you provided: '.$btcAddress.'.

Here is a screenshot of your transaction. 

Please let me know when you have received it on your end. :)

Congrats!

Your next months pay out may be '.$nextMonthPayout.' unless you add more between this month :)

Your Current Balance is '.$currentBalance.' and you only need '.$amountToNextTier.' to get to the next tier and a FREE Month added for you and a guest of your next OmniVentures Trip!

',$to);
    }
    public static function deferPayoutPreEntry($firstName,$currentBalance,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Hey whats up '.$firstName.' so I just updated your numbers, deferring your payment for this month. This has now raised your OmniPool balance!

So now your balance is '.$currentBalance.' 

Your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.

Now that your balance has risen you only have '.$amountToNextTier.' left to get to the Entry Status of OmniPool ($3k) and start receiving your payments!

(Also, just a reminder and no pressure but you can do $200 here, $500 there from each check to raise your balance to get to that $3k amount.)

Please look at https://omnipool.co and make sure your numbers match what I have sent you here.

Let me know if you have any questions :)
',$to);
    }

    public static function deferPayoutEntry($firstName,$currentBalance,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Hey whats up '.$firstName.' so I just updated your numbers, deferring your payment for this month. This has now raised your OmniPool balance!

So now your balance is '.$currentBalance.' 
        
Your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
Now you only have '.$amountToNextTier.' left to get to Tier 1 of OmniPool ($10k). Here you will be able to get One Month FREE on your next OmniVentures Trip for you and a guest!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
        
        ',$to);
    }

    public static function deferPayoutTierX($firstName,$currentBalance,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Hey whats up '.$firstName.' so I just updated your numbers, deferring your payment for this month. This has now raised your OmniPool balance.

So now your balance is '.$currentBalance.' 
        
Your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
I really appreciate your loyalty with us!
        
Now you only need '.$amountToNextTier.' to get to the next tier and another FREE Month for you and a guest of your next OmniVentures Trip!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
        ',$to);
    }
    public static function newDepositPreEntryDefer($currentBalance,$thisMonthPayout,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Just entered your deposit. Here are your updated numbers.

Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout for this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be added into your balance at the end of this month.
        
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
And you only have '.$amountToNextTier.' left to get the Entry Status of OmniPool ($3k) and have the capability to start receiving your payments! Plus be able to come to our OmniVentures Trips in the Future :)
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Let me know if you have any further questions :)
        
        ',$to);
    }

    public static function newDepositPreEntryPayout($currentBalance,$thisMonthPayout,$btcAddress,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Just entered your new deposit. Here are your updated numbers.

Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be paid out to you on by the 3rd day of next month to the BTC Address that you provided: '.$btcAddress.'
        
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
And you only have '.$amountToNextTier.' left to get to Tier 1 of OmniPool ($10k). Here you will be able to get One Month FREE on your next OmniVentures Trip for you and a guest!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Let me know if you have any further questions :)
        ',$to);
    }

    public static function newDepositEntryDefer($currentBalance,$thisMonthPayout,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Just entered your deposit. Here are your updated numbers.

Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout for this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be added into your balance at the end of this month.
        
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
And you only have '.$amountToNextTier.' left to get to Tier 1 of OmniPool ($10k). Here you will be able to get One Month FREE on your next OmniVentures Trip for you and a guest!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
        
        
        ',$to);
    }

    public static function newDepositEntryPayout($currentBalance,$thisMonthPayout,$btcAddress,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Just entered your new deposit. Here are your updated numbers.

Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be paid out to you on by the 3rd day of next month to the BTC Address that you provided: '.$btcAddress.'
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
And you only have '.$amountToNextTier.' left to get to Tier 1 of OmniPool ($10k). Here you will be able to get One Month FREE on your next OmniVentures Trip for you and a guest!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)        
        ',$to);
    }

    public static function newDepositTierXDefer($currentBalance,$thisMonthPayout,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Just entered your deposit. Here are your updated numbers.

Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout for this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be added into your balance at the end of this month.
        
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
You only need '.$amountToNextTier.' to get to the next tier and another FREE Month for you and a guest of your next OmniVentures Trip!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)        
        ',$to);
    }

    public static function newDepositTierXPayout($currentBalance,$thisMonthPayout,$btcAddress,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Just entered your new deposit. Here are your updated numbers.

Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be paid out to you on by the 3rd day of next month to the BTC Address that you provided: '.$btcAddress.'
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
You only need '.$amountToNextTier.' to get to the next tier and another FREE Month for you and a guest of your next OmniVentures Trip!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
               
        ',$to);
    }

    public static function hitEntryStatus($firstName,$currentBalance,$thisMonthPayout,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Congrats '.$firstName.'! You Hit OmniPool\'s Entry Status! 

This means that you now have the capability to receive your payouts sent to you PLUS have the opportunity to come with us to upcoming OmniVentures Trips! 
        
Here are your updated numbers.
        
Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout for this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be added into your balance at the end of this month.
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
And now you only have '.$amountToNextTier.' left to get to Tier 1 of OmniPool ($10k). Here you will be able to get One Month FREE on your next OmniVentures Trip for you and a guest!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
        
               
        ',$to);
    }
    public static function hitTier1($firstName,$currentBalance,$thisMonthPayout,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Congrats '.$firstName.'! You Hit Tier 1! 

This means that you may get One Month FREE for you and a guest of your next OmniVentures Trip!
        
Here are your updated numbers.
        
Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout for this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be added into your balance at the end of this month.
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
You only need '.$amountToNextTier.' to get to the next tier and another FREE Month for you and a guest of your next OmniVentures Trip!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
               
        ',$to);
    }
    public static function hitTierX($firstName,$currentBalance,$thisMonthPayout,$nextMonthPayout,$amountToNextTier,$to){
        self::sendSms('Congrats '.$firstName.'! You Hit Another Tier! 

This means that you may get Another FREE Month for you and a guest of your next OmniVentures Trip!
        
Here are your updated numbers.
        
Your New OmniPool Balance is '.$currentBalance.'
        
Your Payout for this month that may be '.$thisMonthPayout.' (which includes this new deposit\'s payout value) may be added into your balance at the end of this month.
Then your Payout for next month may be '.$nextMonthPayout.' unless you add more before then.
        
You only need '.$amountToNextTier.' to get to the next tier and another FREE Month for you and a guest of your next OmniVentures Trip!
        
Please look at https://omnipool.co and make sure your numbers match what I have sent you here.
        
Also, on there please check if your payout/defer selection is correct for this month. If you want to be deferred, select deferred and if you want to be paid out select paid out and place your BTC Address as well.
        
Let me know if you have any further questions :)
        
               
        ',$to);
    }
    
    public static function sendSms(
        $msg,
        $to='+19548540848'
    ){
        $devNumber=env('DEV_TEST_NUMBER', 0);
        
        if($devNumber!=0){
            $msg=$msg.' ->Recipient: '.$to;
            $to=$devNumber;
        }else{
            $adminNumber=env('ADMIN_NUMBER');
            if($to=="0"){
                $msg=$msg.' ->Empty Number: '.$to;
                $to=$adminNumber;
            }
        }
        
        return self::httpPost(
            'https://app.aloware.com/api/v1/webhook/sms-gateway/send',
            [
                'api_token'=>'EEF412C6',
                'to'=>$to,
                'line_id'=>'1763',
                'message'=>$msg
            ]
        );
    }



    public static function httpPost($url, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        var_dump($response,$data);
        return $response;
    }
}
?>