<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'producto_id',
        'user_id',
        'tipo',
        'cantidad',

        // Kardex
        'stock_anterior',
        'stock_resultante',

        // Retornables
        'es_retorno',
        'movimiento_origen_id',

        // Orden / proyecto
        'orden_compra_numero',
        'proyecto_nombre',

        'observacion',
    ];

    /* =========================
     | RELACIONES
     ========================= */

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 salida original (cuando esto es un retorno)
    public function movimientoOrigen()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_origen_id');
    }

    // 🔁 devoluciones de esta salida
    public function retornos()
    {
        return $this->hasMany(Movimiento::class, 'movimiento_origen_id');
    }

    /* =========================
     | SCOPES ÚTILES
     ========================= */

    // Solo salidas
    public function scopeSalidas($query)
    {
        return $query->where('tipo', 'salida');
    }

    // Solo retornos
    public function scopeRetornos($query)
    {
        return $query->where('es_retorno', true);
    }
}
