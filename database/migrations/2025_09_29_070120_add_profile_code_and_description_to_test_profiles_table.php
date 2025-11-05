<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('test_profiles', function (Blueprint $table) {
            $table->string('profile_code')->nullable()->after('name');
            $table->text('profile_description')->nullable()->after('profile_price');
        });
    }

    
    public function down(): void
    {
        Schema::table('test_profiles', function (Blueprint $table) {
            $table->dropColumn(['profile_code', 'profile_description']);
        });
    }
};
