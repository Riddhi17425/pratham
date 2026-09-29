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
    Schema::table('banners', function (Blueprint $table) {
        $table->enum('status', ['Active', 'In-Active'])->default('Active')->after('image_alt');
    });
}

public function down(): void
{
    Schema::table('banners', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
