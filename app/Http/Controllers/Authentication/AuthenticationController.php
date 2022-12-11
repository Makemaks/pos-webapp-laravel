<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Models\Attendance;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Store;
use Carbon\Carbon;

class AuthenticationController extends Controller
{

    public function forgotPassword(Request $request)
    {

        if ($request->has('email')) {

            //You can add validation login here
            $user = User::Email($request->input('email'))->first();
            if (!$user) {
                return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
            } else {

                $link = URL::temporarySignedRoute(
                    'authentication.reset-password',
                    now()->addMinutes(30),
                    ['id' => $user->user_id]
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

    public function resetPassword(Request $request, $id)
    {

        $user = User::find($id);

        if ($request->has('password_1') && $request->has('password_2')) {
            if ($request->input('password_1') == $request->input('password_2')) {
                $user->password = Hash::make($request->input('password_1'));
                $user->update(); //or $user->save(); 
                Auth::login($user);
                return redirect()->route('dashboard.index')->with('success', 'Password Reset');
            } else {
                return redirect()->back()->with('error', 'Password not the same');
            }
        } else {

            return view('authentication.resetPassword', ['user' => $user]);
        }
    }

    public function login(Request $request)
    {
        // Retrive Input
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // if success login
            User::where('user_id', Auth::user()->user_id)->update(['user_last_login_at' => now()]);

            // clocked in only or log in?
            $attendance = Attendance::where('attendance_user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')->first();
            
            if($attendance) {
                if ($attendance->created_at->isToday() == false) {
                    $attendance_clocked_in = new Attendance();
                    $attendance_clocked_in->attendance_user_id = Auth::user()->user_id;
                    $attendance_clocked_in->attendance_status = 0; //clocked in
                    $attendance_clocked_in->save();
    
                    $attendance_log_in = new Attendance();
                    $attendance_log_in->attendance_user_id = Auth::user()->user_id;
                    $attendance_log_in->attendance_status = 2; //login
                    $attendance_log_in->save();
                } 
            } else {

                $attendance_log_in = new Attendance();
                $attendance_log_in->attendance_user_id = Auth::user()->user_id;
                $attendance_log_in->attendance_status = 2; //login
                $attendance_log_in->save();
            }

            return redirect()->route('dashboard.index');
        }

        // if failed login
        return view('authentication.login')->with('authentication.failed');
    }

    public function logout(Request $request)
    {

       /*  $attendance = new Attendance();
        $attendance->attendance_user_id = Auth::user()->user_id;
        $attendance->attendance_status = 3; //logout
        $attendance->save(); */

        if (Auth::check()) {

            $request->session()->forget('user-session-' . Auth::user()->user_id);
            Auth::logout();
        } else {
            $request->session()->flush();
            Auth::logout();
        }

        return view('authentication.login');
    }

    

    public function adminStore($store)
    {
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

    public function ClockOut()
    {
        $attendance = new Attendance();
        $attendance->attendance_user_id = Auth::user()->user_id;
        $attendance->attendance_status = 1; //logout
        $attendance->save();

        return redirect()->route('dashboard.index')->with('success', 'Successfully Clocked Out');
    }
}
