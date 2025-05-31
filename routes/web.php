<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Route::get('/contact', function()
{
    return "hello";
});

Auth::routes();

Route::get('/home/{secret?}', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['password',])->name('home');

   
    
Route::get('/payout_monthly_user', 'App\Http\Controllers\PayoutController@payout_monthly_user')->name('payout_monthly_user');
Route::get('/payout_breakdown_user', 'App\Http\Controllers\PayoutController@payout_breakdown_user')->name('payout_breakdown_user');
Route::get('/payout_monthly_admin/{user_id}', 'App\Http\Controllers\PayoutController@payout_monthly_admin')->name('payout_monthly_admin');
Route::get('/payout_breakdown_admin/{user_id}', 'App\Http\Controllers\PayoutController@payout_breakdown_admin')->name('payout_breakdown_admin');



Route::get('/user_payouts', 'App\Http\Controllers\PayoutController@user_payouts')->name('user_payouts');
Route::get('/paid_payouts', 'App\Http\Controllers\PayoutController@paid_payouts')->name('paid_payouts');
Route::get('/payouts/{user_id}', [App\Http\Controllers\PayoutController::class, 'payouts'])->name('payouts');
Route::get('/exportPayouts/{user_id}/{monthly_payout}', [App\Http\Controllers\PayoutController::class, 'exportPayouts'])->name('exportPayouts');

Route::get('/getusertransactions/{id}', [App\Http\Controllers\HomeController::class, 'get_user_transactions'])->name('get_user_transactions');

Route::post('/dividenduser', 'App\Http\Controllers\DividendUserController@search')->name('searchuser');

Route::post('/gettransactions', 'App\Http\Controllers\DividendUserController@gettransactions')->name('gettransactions');

Route::post('/submittransactions', 'App\Http\Controllers\DividendUserController@submittransactions')->name('submittransactions');

Route::post('/submitedittransactions', 'App\Http\Controllers\DividendUserController@submitedittransactions')->name('submittransactions');
Route::post('/changeinterestrate', 'App\Http\Controllers\DividendUserController@changeinterestrate')->name('changeinterestrate');
Route::get('/get_user_former_txs', 'App\Http\Controllers\DividendUserController@get_user_former_txs')->name('get_user_former_txs');



Route::post('/deletetransactions', 'App\Http\Controllers\DividendUserController@deletetransactions')->name('deletetransactions');

Route::get('/changepassword','App\Http\Controllers\PasswordController@changePassword')->name('changePasswordScreen');

Route::post('/changepassword','App\Http\Controllers\PasswordController@setPassword')->name('changePassword');

Route::get('/test', 'App\Http\Controllers\DividendUserController@test')->name('test');

Route::get('/performance', 'App\Http\Controllers\PerformanceController@index')->name('performance');

Route::get('/userperformance', 'App\Http\Controllers\PerformanceController@index')->name('userperformance');

Route::get('/order_transactions', 'App\Http\Controllers\OrderTransactionsController@index')->name('order_transactions');

