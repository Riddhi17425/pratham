<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->string('title');
            $table->string('name');
            $table->string('product_url')->nullable()->after('name');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();

            $table->text('description')->nullable();
            $table->string('catalogue')->nullable();           // PDF file name
            $table->longText('technical_details')->nullable(); // editor html

            $table->enum('status', ['Active', 'In-Active'])->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
