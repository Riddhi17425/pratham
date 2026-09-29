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
    // purani `date` column ka naam `from_date` ho jayega (data safe rahega)
    Schema::table('events', function (Blueprint $table) {
        $table->renameColumn('date', 'from_date');
    });

    Schema::table('events', function (Blueprint $table) {
        $table->date('to_date')->nullable()->after('from_date');
    });
}

public function down(): void
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('to_date');
    });

    Schema::table('events', function (Blueprint $table) {
        $table->renameColumn('from_date', 'date');
    });
}
};
