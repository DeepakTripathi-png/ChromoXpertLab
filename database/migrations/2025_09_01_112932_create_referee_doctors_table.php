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
        Schema::create('referee_doctors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('commission_percent')->nullable();
            $table->string('address')->nullable();
            $table->string('created_ip_address')->nullable();
            $table->string('modified_ip_address')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('modified_by')->nullable();
            $table->enum('status', ['active', 'delete', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referee_doctors');
    }
};
