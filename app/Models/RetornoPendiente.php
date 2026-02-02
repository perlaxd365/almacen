<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetornoPendiente extends Model
{
    protected $table = 'retornos_pendientes';

    protected $fillable = [
        'producto_id',
        'user_id',
        'orden_compra_numero',
        'proyecto_nombre',
        'cantidad_entregada',
        'cantidad_devuelta',
        'cantidad_pendiente',
        'estado',
    ];

    /* ================= RELACIONES ================= */

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
