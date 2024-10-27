<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function new()
    {
        return view('vehicles.new');
    }
    public function arrest()
    {
        return view('criminals.arrest');
    }
}
