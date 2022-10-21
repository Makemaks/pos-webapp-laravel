<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


use App\Models\User;
use App\Models\Setting;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        
       
        if (Auth::check()) {
            
            $queryValue  = $request->route()->parameters();
            $modelID = array_pop($queryValue);
      
            $userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();
            $settingModel = Setting::where('settingtable_id', $userModel->store_id)->first();

            if( $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'lock_screen_enabled') ) {
                return redirect()->route('authentication.logout');
                return $next($request);
            } else {
                if ($request->session()->has('id') && $request->session()->has('view') && $request->session()->has('type')) {
                    $request->session()->keep('type');
                    $request->session()->keep('view');
                    $request->session()->keep('id');
                }
                //add session to type and remove view as first step
        
                if( $request['id'] && $request['type']){
                    $request->session()->forget('view');
                    $request->session()->flash('type', $request['type']);
                    $request->session()->flash('id', $request['id']);
                }
                
                
                if($request['id'] && $request['view']){
                  
                    $setting_stock_group = $settingModel->setting_stock_group[$request['id']]['type'];
                    $request->session()->flash('type', Setting::SettingStockGroup()[$setting_stock_group - 1] );
        
                    $request->session()->flash('view', $request['view']);
                    $request->session()->flash('id', $request['id']);
                }
        
        
                if ($request->session()->has('person_id')) {
                    $request->session()->keep('person_id');
                }
                
                
            }

        }
        

        return $next($request);
        
       

       

        

    }
}
