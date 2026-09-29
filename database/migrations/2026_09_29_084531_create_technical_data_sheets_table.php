<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_data_sheets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->string('brochure')->nullable(); // PDF file name
            $table->string('pdf')->nullable();      // PDF file name

            $table->enum('status', ['Active', 'In-Active'])->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_data_sheets');
    }
};
