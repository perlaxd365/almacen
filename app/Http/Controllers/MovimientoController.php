<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    //
    public function index()
    {
        return view('admin.movimientos.index');
    }
}
