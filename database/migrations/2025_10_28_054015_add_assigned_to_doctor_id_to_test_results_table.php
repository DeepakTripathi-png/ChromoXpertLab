<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('test_results', function (Blueprint $table) {
            // Add columns without foreign key constraints
            $table->bigInteger('assigned_to_doctor_id')->nullable()->after('signed_by_id');
            $table->timestamp('assigned_at')->nullable()->after('assigned_to_doctor_id');
            $table->bigInteger('assigned_by')->nullable()->after('assigned_at');
        });
    }

    public function down()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn(['assigned_to_doctor_id', 'assigned_at', 'assigned_by']);
        });
    }
};
