<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserParent extends Model
{
    //
    protected $table = 'transactions';


    /*
    public function scopeDividends($query){

		return $query->where('transaction_type_id','6')->get();
		//return $query->where('user_id','16215');

    }

    public function scopeContributionEntries($query){

		return $query->where('transaction_type_id','6')->get();
		//return $query->where('user_id','16215');

    }*/

    public function scopeUsersWithDividends($query){

		return $query->where('transaction_type_id','6')->distinct()->pluck('user_id');
		//return $query->where('user_id','16215');

    }

    public function scopeGetDeposits($query,$id,$date,$org){
    	//dd($query);
    	//'2020-03-31'

		return $query->whereIn('transaction_type_id',[1,9])->where([
			['user_id', $id],
			['investment_type',$org],
			['date_transaction','<=',$date]
	])->orderBy('date_transaction','asc')->orderBy('id','asc')->get();
		//return $query->where('user_id','16215');

    }

    public function scopeGetContributions($query,$id,$date,$org){

		return $query->where('transaction_type_id','6')->where([
			['user_id',$id],
			['investment_type',$org],
			['date_transaction','<=',$date]
		])->orderBy('date_transaction','asc')->orderBy('id','asc')->get();
		//return $query->where('user_id','16215');

    }

}
