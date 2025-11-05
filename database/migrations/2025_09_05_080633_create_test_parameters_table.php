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
        Schema::create('test_parameters', function (Blueprint $table) {
            $table->id();
                $table->bigInteger('test_id')->nullable();
                $table->enum('row_type', ['component', 'title']);
                $table->string('name')->nullable(); // For components
                $table->string('title')->nullable(); // For titles
                $table->string('unit')->nullable();
                $table->enum('result_type', ['text', 'select'])->default('text');
                $table->text('reference_range')->nullable();
                $table->integer('sort_order')->default(0);
                
                // Add these fields to match your tests table
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
        Schema::dropIfExists('test_parameters');
    }
};
