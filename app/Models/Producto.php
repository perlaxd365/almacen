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
        'stock_minimo',
        'estado'
    ];

    public function esConsumible()
    {
        return $this->tipo === 'consumible';
    }

    public function esRetornable()
    {
        return $this->tipo === 'retornable';
    }
}
