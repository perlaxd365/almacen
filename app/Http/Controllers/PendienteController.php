<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendienteController extends Controller
{
    //
    public function index()
    {
        return view("admin.pendiente.index");
    }
}
