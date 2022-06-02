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

        $requestGeneral = [];
        $requestGeneral['ibutton'] = $request->ibutton;
        $requestGeneral['secret_number'] = $request->secret_number;
        $requestGeneral['ni_number'] = $request->ni_number;

        $requestLevel = [];
        $requestLevel['default_menu_level'] = $request->default_menu_level;
        $requestLevel['default_price_level'] = $request->default_price_level;
        $requestLevel['default_floorplan_level'] = $request->default_floorplan_level;

        $requestCommision = [];
        $requestCommision['rate_1'] = $request->rate_1;
        $requestCommision['rate_2'] = $request->rate_2;
        $requestCommision['rate_3'] = $request->rate_3;
        $requestCommision['rate_4'] = $request->rate_4;

        $requestUserPay = [];
        $requestUserPay['pay_rate'] = $request->pay_rate;
        $requestUserPay['from_date'] = $request->from_date;
        $requestUserPay['to_date'] = $request->to_date;
        $requestUserPay['start_hour'] = $request->start_hour;
        $requestUserPay['end_hour'] = $request->end_hour;

        $employment->employment_setup = $requestEmployment;
        $employment->employment_general = $requestGeneral;
        $employment->employment_level_default = $requestLevel;
        $employment->employment_commision = $requestCommision;
        $employment->employment_user_pay = $requestUserPay;

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

        $requestGeneral = [];
        $requestGeneral['ibutton'] = $request->ibutton;
        $requestGeneral['secret_number'] = $request->secret_number;
        $requestGeneral['ni_number'] = $request->ni_number;

        $requestLevel = [];
        $requestLevel['default_menu_level'] = $request->default_menu_level;
        $requestLevel['default_price_level'] = $request->default_price_level;
        $requestLevel['default_floorplan_level'] = $request->default_floorplan_level;

        $requestCommision = [];
        $requestCommision['rate_1'] = $request->rate_1;
        $requestCommision['rate_2'] = $request->rate_2;
        $requestCommision['rate_3'] = $request->rate_3;
        $requestCommision['rate_4'] = $request->rate_4;

        $requestUserPay = [];
        $requestUserPay['pay_rate'] = $request->pay_rate;
        $requestUserPay['from_date'] = $request->from_date;
        $requestUserPay['to_date'] = $request->to_date;
        $requestUserPay['start_hour'] = $request->start_hour;
        $requestUserPay['end_hour'] = $request->end_hour;

        $employment->employment_setup = array_merge($employment->employment_setup, $requestEmployment);
        $employment->employment_general = array_merge($employment->employment_general, $requestGeneral);
        $employment->employment_level_default = array_merge($employment->employment_level_default, $requestLevel);
        $employment->employment_commision = array_merge($employment->employment_commision, $requestCommision);
        $employment->employment_user_pay = array_merge($employment->employment_user_pay, $requestUserPay);

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
