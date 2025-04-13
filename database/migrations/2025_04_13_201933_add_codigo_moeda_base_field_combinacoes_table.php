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
        Schema::table('combinacoes', function (Blueprint $table) {
            $table->string('codigo_moeda_base')->nullable()->after('id')->index('idx_codigo_moeda_base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('combinacoes', function (Blueprint $table) {
            $table->dropIndex('idx_codigo_moeda_base');
            $table->dropColumn('codigo_moeda_base');
        });
    }
};
