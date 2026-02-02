<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retornos_pendientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('orden_compra_numero');
            $table->string('proyecto_nombre');

            $table->integer('cantidad_entregada');
            $table->integer('cantidad_devuelta')->default(0);
            $table->integer('cantidad_pendiente');

            $table->enum('estado', ['pendiente', 'cerrado'])->default('pendiente');

            $table->timestamps();

            /* 🔎 índices importantes */
            $table->index(['producto_id', 'user_id']);
            $table->index('estado');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retorno_pendientes');
    }
};
