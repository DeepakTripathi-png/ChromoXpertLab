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
        Schema::table('test_results', function (Blueprint $table) {
            // Doctor-specific approval status: tracks if the assigned doctor has reviewed/approved/rejected
            // Enum to handle pending (default), approved, or rejected states
            // Assumes approval/rejection is always by the assigned doctor (use assigned_to_doctor_id)
            $table->enum('doctor_approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            
            // Timestamp when doctor approved/rejected
            $table->timestamp('doctor_approved_at')->nullable()->after('doctor_approval_status');
            
            // Optional rejection reason/comment from doctor
            $table->text('doctor_rejection_comment')->nullable()->after('doctor_approved_at');
            
            // Admin approval flag: boolean to track if admin has signed/approved, which overrides doctor status for completion
            $table->boolean('admin_approved')->default(false)->after('doctor_rejection_comment');
            
            // Timestamp when admin approved
            $table->timestamp('admin_approved_at')->nullable()->after('admin_approved');
            
            // Foreign key to admin/user who approved (ties to created_by/modified_by or users table)
            // Can sync with signed_by_id if admin signs
            $table->unsignedBigInteger('admin_approved_by')->nullable()->after('admin_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn([
                'doctor_approval_status',
                'doctor_approved_at',
                'doctor_rejection_comment',
                'admin_approved',
                'admin_approved_at',
                'admin_approved_by'
            ]);
        });
    }
};