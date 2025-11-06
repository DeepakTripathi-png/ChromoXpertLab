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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained()->onDelete('cascade');
			$table->foreignId('test_id')->constrained('tests')->onDelete('cascade');
			$table->decimal('price', 10, 2)->nullable();
			$table->integer('quantity')->default(1);
			$table->string('status')->default('active'); // optional status field
			$table->string('created_ip_address')->nullable();
			$table->string('modified_ip_address')->nullable();
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
			$table->dropColumn([
				'status',
				'created_ip_address',
				'modified_ip_address',
				'created_by',
				'modified_by',
			]);
		});
    }
};
