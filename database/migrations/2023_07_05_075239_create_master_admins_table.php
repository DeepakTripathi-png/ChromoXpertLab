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
        Schema::create('master_admins', function (Blueprint $table) {
            $table->id();
            
            $table->string('user_type')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('role_id')->nullable();
            $table->string('address')->nullable();
            $table->string('user_profile_image_path')->nullable();
            $table->string('user_profile_image_name')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('access_token')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->rememberToken();
            $table->bigInteger('otp')->nullable();

            $table->enum('status',['active','delete','inactive'])->default('active');
            $table->string('created_ip_address')->nullable();
            $table->string('modified_ip_address')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('modified_by')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_admins');
    }
};
