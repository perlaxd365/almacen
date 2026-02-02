<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'unidad',
        'stock',
        'estado'
    ];
    protected $casts = [
        'retornable' => 'boolean',
    ];

    public function esConsumible()
    {
        return $this->tipo === 'consumible';
    }

    public function esRetornable()
    {
        return $this->tipo === 'retornable';
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
