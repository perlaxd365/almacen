<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {

            // 🔁 Indica si esta entrada es una devolución
            $table->boolean('es_retorno')
                ->default(false)
                ->after('tipo');

            // 🔗 Apunta a la salida original (para retornables)
            $table->foreignId('movimiento_origen_id')
                ->nullable()
                ->after('id')
                ->constrained('movimientos')
                ->nullOnDelete();

            $table->boolean('es_prestamo_largo')
                ->default(false)
                ->after('tipo');
        });
    }

    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropForeign(['movimiento_origen_id']);
            $table->dropColumn(['es_retorno', 'movimiento_origen_id']);
        });
    }
};
