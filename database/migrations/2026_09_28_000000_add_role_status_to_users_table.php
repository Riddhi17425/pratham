<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('role')->default(0)->after('password'); // 1 = Super Admin, 2 = Admin
            $table->boolean('status')->default(true)->after('role');
            $table->softDeletes();
        });

        // Purane is_admin column ka data role me le aao, phir column hata do
        if (Schema::hasColumn('users', 'is_admin')) {
            DB::table('users')->where('is_admin', true)->update(['role' => 1]);
            Schema::table('users', fn (Blueprint $table) => $table->dropColumn('is_admin'));
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['role', 'status']);
        });
    }
};
