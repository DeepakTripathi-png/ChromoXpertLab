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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['admin', 'branch', 'doctor'])->default('admin');  // Fixed default
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('mobile')->nullable();  // Added for branches/doctors
        $table->text('address')->nullable();   // Added if needed
        $table->enum('status', ['active', 'delete', 'inactive'])->default('active');
        $table->datetime('last_login')->nullable();  // Added for login tracking
        $table->bigInteger('role_id')->nullable();   // Added for privileges
        $table->string('created_ip_address')->nullable();
        $table->string('modified_ip_address')->nullable();
        $table->bigInteger('created_by')->nullable();
        $table->bigInteger('modified_by')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
