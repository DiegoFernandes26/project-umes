<?php

namespace App\Http\Controllers;

use App\Escola;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CadController extends Controller{
    public function index(){
        $escola = Escola::all();
        return view('admin.index', compact('escola'));
    }
}
