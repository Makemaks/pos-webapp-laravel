<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{

    private $userList;
    private $userModel;
    private $settingModel;




    public function Index()
    {

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();


        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
            ->paginate(20);



        return view('user.index', ['data' => $this->Data()]);
    }

    public function Create()
    {

        $this->userModel = new User();
        return view('user.create', ['data' => $this->Data()]);
    }

    public function Store(Request $request)
    {

        // User Create
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_account_id = Auth::user()->user_account_id;
        $user->user_type = $request->user_type;
        $user->save();

        // Person Create
        $person = new Person();
        $person->person_user_id = $user->user_id;
        $person->person_type = $request->person_type;
        $requestPersonName = [];
        $requestPersonName['person_firstname'] = $request->person_firstname;
        $requestPersonName['person_lastname'] = $request->person_lastname;
        $requestPersonName['person_preferred_name'] = $request->person_preferred_name;
        $person->person_name = $requestPersonName;
        $person->save();

        // User Person Id Update
        $user->user_person_id = $person->person_id;
        $user->save();

        // Employment Create
        $employment = new Employment();

        $employment->employment_user_id = $user->user_id;
        $requestEmployment = [];
        $requestEmployment['Allowed Function'] = $request->Allowed_Function;
        $requestEmployment['Allowed Modes'] = $request->Allowed_Modes;
        $requestEmployment['Employee Job'] = $request->Employee_Job;
        $requestEmployment['User Control'] = $request->User_Control;
        $employment->employment_setup = $requestEmployment;

        $employment->save();


        return \redirect()->route('user.index')->with('success', 'User Updated');
    }

    public function Edit($user)
    {
        $this->userModel = User::Person('user_id', $user)->first();
        return view('user.edit', ['data' => $this->Data()]);
    }

    public function Update(Request $request, $user)
    {

        // Hashing Password
        $password = Hash::make($request->password);

        // User Update
        $userSave = User::find($user);
        $userSave->email = $request->email;
        $userSave->password = $password;
        $userSave->user_type = $request->user_type;
        $userSave->save();

        // Person Update
        $person = Person::find($userSave->user_person_id);
        $person->person_type = $request->person_type;

        $requestPersonName = [];
        $requestPersonName['person_firstname'] = $request->person_firstname;
        $requestPersonName['person_lastname'] = $request->person_lastname;
        $requestPersonName['person_preferred_name'] = $request->person_preferred_name;
        $person->person_name = array_merge($person->person_name, $requestPersonName);

        $person->save();

        // Employment Update
        $employment = Employment::where('employment_user_id', $user)->first();

        $requestEmployment = [];
        $requestEmployment['Allowed Function'] = $request->Allowed_Function;
        $requestEmployment['Allowed Modes'] = $request->Allowed_Modes;
        $requestEmployment['Employee Job'] = $request->Employee_Job;
        $requestEmployment['User Control'] = $request->User_Control;
        $employment->employment_setup = array_merge($employment->employment_setup, $requestEmployment);

        $employment->save();

        return \redirect()->route('user.index')->with('success', 'User Updated');
    }

    public function destroy($user)
    {
        $user_person_id = User::find($user)->user_person_id;


        User::destroy($user);
        Person::find($user_person_id)->delete();
        Employment::where('employment_user_id', $user)->delete();

        return redirect()->route('user.index');
    }

    private function Data()
    {
        return [
            'userList' => $this->userList,
            'userModel' => $this->userModel,
            'settingModel' => $this->settingModel
        ];
    }
}
