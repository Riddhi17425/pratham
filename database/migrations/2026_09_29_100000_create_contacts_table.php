<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->text('message');
<<<<<<< HEAD
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
=======
            $table->string('product')->nullable();
>>>>>>> eebc9ff31fdfc9b99680186a13a58c1a8e062b9e
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
