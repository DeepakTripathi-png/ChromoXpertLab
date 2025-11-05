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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('pet_code')->unique()->nullable();
            $table->bigInteger('pet_parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('species')->nullable();
            $table->string('breed')->nullable();
            $table->string('type')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('age')->nullable();
            $table->string('weight')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_path')->nullable();
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
        Schema::dropIfExists('pets');
    }
};
