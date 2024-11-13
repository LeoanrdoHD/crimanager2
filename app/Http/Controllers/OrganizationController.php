<?php

namespace App\Http\Controllers;

use App\Models\organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function show($id)
{
    $organization = organization::findOrFail($id); // Encuentra la organización por ID o muestra un error 404
    return view('organizations.show', compact('organization')); // Devuelve la vista y pasa la organización
}
}
