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
        Schema::disableForeignKeyConstraints();

        Schema::create('job_card_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_card_id')->constrained('job_cards');
            $table->string('type', 20);
            $table->foreignId('service_id')->nullable()->constrained();
            $table->foreignId('part_id')->nullable()->constrained();
            $table->foreignId('employee_id')->nullable()->constrained();
            $table->decimal('buying_price', 8, 2)->default(0);
            $table->decimal('selling_price', 8, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('sub_total', 8, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_items');
    }
};
