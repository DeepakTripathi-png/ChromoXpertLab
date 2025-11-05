<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->bigInteger('signed_by_id')->unsigned()->nullable()->after('comment');
            $table->dateTime('signed_date')->nullable()->after('signed_by_id');
            $table->enum('done', ['yes', 'no'])->default('no')->after('signed_date');
        });
    }

   
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn(['signed_by_id', 'signed_date', 'done']);
        });
    }
};
