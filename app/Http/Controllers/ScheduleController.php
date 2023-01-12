<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() {
        return 'test';
    }

    public function schedule(Request $request) {
        $action = $request->session()->get('action');
        $view = $request->session()->get('view');
        dd($action,$view,$request->all());
    }
}
