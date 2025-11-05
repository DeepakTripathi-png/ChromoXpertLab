<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionDetailsToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('total');
            $table->string('transaction_id')->nullable()->after('payment_mode');
            $table->enum('payment_status', ['Pending', 'Completed', 'Failed'])->nullable()->after('transaction_id');
            $table->date('payment_date')->nullable()->after('payment_status');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['payment_mode', 'transaction_id', 'payment_status', 'payment_date']);
        });
    }
}
