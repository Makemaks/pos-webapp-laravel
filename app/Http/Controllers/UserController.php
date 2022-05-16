<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Store;
use App\Models\Setting;

class UserController extends Controller
{

    private $userList;
    private $userModel;
    private $settingModel;
    

   

    public function Index(){

         $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
       

        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->paginate(20);

        return view('user.index', ['data' => $this->Data()]);   
       
    }

    public function Create(){

        $this->userModel = New User();
        return view('user.create', ['data' => $this->Data()]);  
    }

    public function Store(Request $request){


        User::insert($request->except('_token', '_method'));
        return view('user.index', ['data' => $this->Data()]);
    }

    public function Edit($user){
        $this->userModel = User::Person('user_id', $user)->first();
        return view('user.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $user){

       User::find($user)
       ->update($request->except('_token', '_method'));

        return view('user.edit', ['data' => $this->Data()]);  
    }

    public function Destroy($user){
        User::destroy($user);
        PersonUser::where('person_User_User_id', $user)
        ->destroy();

        return redirect()->route('user.index');  
    }

    private function Data(){
        return [
            'userList' => $this->userList,   
            'userModel' => $this->userModel,   
            'settingModel' => $this->settingModel       
        ];
       
    }
}
