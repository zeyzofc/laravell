<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders',function(Blueprint $table){
             $table->enum('payment_status', ['1', '2', '3', '4'])->comment('1=Waiting Payment, 2=Payment Successfull, 3=Expired, 4=Canceled')->after('grand_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders',function(Blueprint $table){
            $table->dropColumn('payment_status');
        });
    }
};