<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    //
    public function index(){
        return view("admin.trabajador.index");
    }
}
