<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Models\Setting;
use App\Models\User;

class SettingController extends Controller
{

  private $settingModel;
  private $settingList;

  public function Index(Request $request){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        //$setting_stock_group = ["category", "group", "plu"];
        //$setting_stock_group_key = array_search( $request->session()->get('view'), $setting_stock_group);


        if ( $request->session()->has('view')) {
            $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)
            ->first();
            $request->session()->keep('view');

            return view('menu.setting.group', ['data' => $this->Data()]);
        } else {
            $this->settingList = Setting::paginate(20);
            return view('setting.index', ['data' => $this->Data()]);
        }
    
  }

  public function Create(){

    $this->settingModel = new Setting();

      return view('Setting.create',['data' => $this->Data()]);
  }

  public function Store(Request $request){

    if($request->hasFile('setting_logo_url')){

        $upload = $request->setting_logo_url->store('/images/uploads');

    }
        $settingInput = $request->except('_token', '_method');

        $settingInput['setting_logo_url'] = $upload;



        $settingInput['created_at'] =  \Carbon\Carbon::now();
        $settingInput['updated_at'] = \Carbon\Carbon::now();


        Setting::insert($settingInput);

        return back()->with('success', 'Setting Added Successfuly');
  }

  public function Edit($setting){
      $setting = Setting::find($setting);
      return view('Setting.edit', ['project' => $setting]);  
  }

  public function Update(Request $request, $setting){

    $this->settingModel = Setting::find($setting);
        $settingInput = $request->except('_token', '_method');

      return view('Setting.edit', ['project' => $setting]);  
  }

  public function Destroy($setting){

      Setting::destroy($setting);

      return back()->with('success', 'Setting Deleted Successfuly');
  }

  private function Data(){
    return [
        'settingModel' => $this->settingModel,
        'settingList' => $this->settingList,
    ];
    }

}
