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
        Schema::create('test_result_components', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_result_id');
            $table->bigInteger('component_id');
            $table->text('result')->nullable();
            $table->enum('result_status', ['normal', 'abnormal', 'critical'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_result_components');
    }
};
