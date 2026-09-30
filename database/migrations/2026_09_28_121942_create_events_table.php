<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('location');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status', ['Active', 'In-Active'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};