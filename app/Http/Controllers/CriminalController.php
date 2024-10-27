<?php

namespace App\Http\Controllers;

use App\Models\criminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class CriminalController extends Controller
{
    public function create()
    {
        $criminals= criminal::get();
        return view('criminals.create')->with('criminals',$criminals);
    }
    
    public function search_cri()
    {
        $criminals = criminal::all();
        return view('criminals.search_cri',compact('criminals'));
    }
    public function store(Request $request)
    {
        return $request->all();
    }



    public function arrest()
    {
        return view('criminals.arrest');
    }
    public function search_arrest()
    {
        $criminals = criminal::all();
        return view('criminals.search_arrest',compact('criminals'));
    }
    public function store_arrest(Request $request)
    {
        return $request->all();
    }
}
