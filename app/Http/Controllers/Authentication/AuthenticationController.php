<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Store;

class AuthenticationController extends Controller
{

    public function forgotPassword(Request $request){
        
            if ($request->has('email')) {               
      
                    //You can add validation login here
                $user = User::Email($request->input('email'))->first();
                if (!$user) {
                    return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
                }
                else{
                    
                    $link = URL::temporarySignedRoute(
                        'authentication.reset-password', now()->addMinutes(30), ['id' => $user->user_id]
                    );
    
                    Mail::to($request->input('email'))
                    ->send(new \App\Mail\ResetPassword($user->person_firstname, $user->email, $link));
    
                    if (Mail::failures()) {
                        return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);                       
                    } else {
                        return redirect()->back()->with('success', trans('A reset link has been sent to your email address.'));
                    } 
                }
               
            }
        return view('authentication.forgotPassword');
       
    }
     
    public function resetPassword(Request $request, $id){
   
        $user = User::find($id);

        if ($request->has('password_1') && $request->has('password_2')) {         
            if ($request->input('password_1') == $request->input('password_2')) {
                $user->password = Hash::make($request->input('password_1'));
                $user->update(); //or $user->save(); 
                Auth::login($user);
                return redirect()->route('dashboard.index')->with('success', 'Password Reset');
            }else{
                return redirect()->back()->with('error', 'Password not the same');
            }

        }else{
           
            return view ('authentication.resetPassword', ['user' => $user]);
        }
        
    }

    public function login(Request $request){
        // Retrive Input
        $credentials = $request->only('email', 'password');       
     
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // if success login
            User::where('user_id', Auth::user()->user_id)->update(['user_last_login_at' => now()]);
            return redirect()->route('dashboard.index');
        }
       
        // if failed login
        return view('authentication.login')->with('authentication.failed');
    }

    public function logout(Request $request){
      
       if (Auth::check()) {

            $request->session()->forget('user-session-'.Auth::user()->user_id);    
            Auth::logout();
       }else{
            $request->session()->flush();    
            Auth::logout();
       }

       

       return view('authentication.login');
       
    }

    public function adminStore($store){
         // Retrive Input
      
         $storeModel = Store::find($store);

         //get admin for this store
         $userPersonModel = User::Person('user_account_id', $storeModel->store_account_id)
         ->where('user_type', 0)
         ->first();

         $userModel = User::find($userPersonModel->user_id);
       
         // if success login
         Auth::logout();
         Auth::login($userModel);
       
         return redirect()->route('dashboard.index')->with('success', 'Successfully Logged In');
       
       
    }
}
