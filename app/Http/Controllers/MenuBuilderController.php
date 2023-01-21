<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuBuilderController extends Controller
{
    public function index(Request $request)
    {
        return view('menu-builder.index');
    }
}
