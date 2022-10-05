<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AppAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $html;

    public function index(Request $request)
    {
        //$request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'lock_screen_enabled');

        // dd($request->all());
        if ($request->has('lock_screen')){
            $unlock = User::find(Auth::id())->user_auth_check;
            $pin = $request->pin;
            $is_unlock = Arr::where($unlock, function ($value, $key) use($pin) {
                if($value['type'] == 0 && $value['value'] == $pin) {
                    return true;
                }
            });

            if(empty($is_unlock)) {
                $status = 0;
            } else {
                $status = 1;
            }
          return response()->json(['status' => $status]);
        }

        $lock_screen_enabled = $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'lock_screen_enabled');

       if($request->has('lock_screen_enabled') && $lock_screen_enabled == false) {
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'lock_screen_enabled', true);
            return response()->json(['status' => 'screenlock']);
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    private function Data(){

        return [
            'html' => $this->html,
        ];
    }
}
