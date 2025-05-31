<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->foreignId('user_id')->constrained();
            $table->integer('year');
            $table->string('txHash')->nullable()->default(null);
            $table->decimal('amount', 13, 4);
            $table->decimal('running_balance', 13, 4);
            $table->tinyInteger('isDeferred');
            $table->tinyInteger('isProcessed');
            $table->unique(['user_id', 'month','year','isDeferred']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payouts');
    }
}
