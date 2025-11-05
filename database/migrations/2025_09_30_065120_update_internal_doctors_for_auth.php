<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internal_doctors', function (Blueprint $table) {
            $table->string('password')->after('email')->nullable();
            $table->unsignedBigInteger('role_id')->nullable()->after('mobile');
            $table->string('last_login')->nullable()->after('role_id');
            $table->string('remember_token', 100)->nullable()->after('last_login');
        });
    }

    public function down(): void
    {
        Schema::table('internal_doctors', function (Blueprint $table) {
            $table->dropColumn(['password', 'role_id', 'last_login', 'remember_token']);
        });
    }
};