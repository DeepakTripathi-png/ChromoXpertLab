<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_rejected_by')->nullable()->after('admin_approved_by');
            $table->timestamp('admin_rejected_at')->nullable()->after('admin_rejected_by');
        });
    }

    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn(['admin_rejected_by', 'admin_rejected_at']);
        });
    }
};
