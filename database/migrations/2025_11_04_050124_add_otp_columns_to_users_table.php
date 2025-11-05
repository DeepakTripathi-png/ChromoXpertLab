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
        Schema::table('users', function (Blueprint $table) {
            // store a short numeric OTP (4-6 digits). nullable because old rows won't have it.
            $table->string('otp', 6)->nullable()->after('remember_token');
            // expiry timestamp for the OTP
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
            // optional: track attempts to prevent brute force
            $table->unsignedTinyInteger('otp_attempts')->default(0)->after('otp_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['otp', 'otp_expires_at', 'otp_attempts']);
        });
    }
};
