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
        Schema::create('sample_collections', function (Blueprint $table) {
            $table->id();
            $table->string('sample_code')->nullable();
            $table->bigInteger('appointment_id')->nullable();
            $table->string('sample_type')->nullable();
            $table->bigInteger('collection_source_id')->nullable();
            $table->bigInteger('destination_lab_id')->nullable();
            $table->enum('status', [
                'Pending',
                'Collected',
                'In Transit',
                'Received',
                'Processing',
                'Analyzed',
                'Reported',
                'Completed',
                'Cancelled',
                'Rejected'
            ])->default('Pending');
            $table->date('collection_date')->nullable();
            $table->time('collection_time')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('sample_collections');
    }
};
