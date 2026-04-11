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
    Schema::table('santris', function (Blueprint $table) {
        // Kita tambahkan kolom uid setelah kolom nama
        $table->string('uid')->nullable()->after('nama'); 
    });
}

public function down(): void
{
    Schema::table('santris', function (Blueprint $table) {
        $table->dropColumn('uid');
    });
}
};
