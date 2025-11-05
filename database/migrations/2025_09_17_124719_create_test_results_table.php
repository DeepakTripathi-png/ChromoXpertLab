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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->string('test_result_code')->nullable();
            $table->bigInteger('appointment_id')->nullable();
            $table->bigInteger('test_id')->nullable();
            $table->text('result')->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium'); 
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->text('comment')->nullable();
            $table->string('created_ip_address')->nullable();
            $table->string('modified_ip_address')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('modified_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
