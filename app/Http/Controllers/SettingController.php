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

    public function Index(Request $request)
    {
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        //$setting_stock_group = ["category", "group", "plu"];
        //$setting_stock_group_key = array_search( $request->session()->get('view'), $setting_stock_group);


        if ($request->session()->has('view')) {
            $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)
                ->first();
            $request->session()->keep('view');

            return view('menu.setting.group', ['data' => $this->Data()]);
        } else {
            $this->settingList = Setting::paginate(20);
            return view('setting.index', ['data' => $this->Data()]);
        }
    }

    public function Create()
    {
        $this->settingModel = new Setting();
        return view('Setting.create', ['data' => $this->Data()]);
    }

    public function Store(Request $request)
    {
        // Check condition from request to add new setting_stock_group
        if ($request->code) {
            $this->settingModel = Setting::find($request['setting_id']);
            $settingInput = $request->except('_token', '_method', 'setting_id', 'created_at', 'updated_at');
            $stock_group = $this->settingModel->setting_stock_group;
            if(!empty($stock_group)){
                $last_key = (int)collect($stock_group)->keys()->last();
                $stock_group[$last_key + 1] = $settingInput;
            } else {
                $stock_group[1] = $settingInput;
            }
            $this->settingModel->setting_stock_group = $stock_group;
            $this->settingModel->save();
            return back()->with('success', 'Added Successfuly');
        }
        if($request->session()->get('view') == 'case-size'){
            $this->settingModel = Setting::find($request['setting_id']);
            $settingInput = $request->except('_token', '_method', 'setting_id', 'created_at', 'updated_at');
            $case_size = $this->settingModel->setting_stock_case_size;
            if(!empty($case_size)){
                $last_key = (int)collect($case_size)->keys()->last();
                $case_size[$last_key + 1] = $settingInput;
            } else {
                $case_size[1] = $settingInput;
            }
            $this->settingModel->setting_stock_case_size = $case_size;
            $this->settingModel->save();
            return back()->with('success', 'Added Successfuly');
        }
        if ($request->hasFile('setting_logo_url')) {
            
            $upload = $request->setting_logo_url->store('/images/uploads');
        }
        
        $settingInput = $request->except('_token', '_method');
        $settingInput['setting_logo_url'] = $upload;



        $settingInput['created_at'] =  \Carbon\Carbon::now();
        $settingInput['updated_at'] = \Carbon\Carbon::now();


        Setting::insert($settingInput);

        return back()->with('success', 'Setting Added Successfuly');
    }

    public function Edit(Request $request, $setting)
    {
        $this->settingModel = Setting::find($setting);

        // Check condition from url to edit setting_stock_group
        if($request->has('index')) {
            $request->session()->reflash();
            if($request->session()->get('view') == 'case-size'){
                $this->settingModel['setting_stock_case_size'] = $this->settingModel['setting_stock_case_size'][$request->index];
                $this->settingModel['edit'] = true;
                return view('menu.setting.settingCaseSize', ['data' => $this->Data()]);
            }else{
                $this->settingModel['setting_stock_group'] = $this->settingModel['setting_stock_group'][$request->index];
                $this->settingModel['edit'] = true;
                return view('menu.setting.settingStockGroup', ['data' => $this->Data()]);
            }
        }
        return view('Setting.edit', ['project' => $setting]);
    }

    public function Update(Request $request, $setting)
    {
        $request->session()->reflash();
        if($request->session()->get('view') == 'case-size'){
            $this->settingModel = Setting::find($setting);
            $settingInput = $request->except('_token', '_method', 'created_at', 'updated_at');
            
            // Check condition from request to update particular index of setting_stock_case_size
            if ($request->setting_stock_case_size) {
                $this->settingModel->setting_stock_case_size = $settingInput['setting_stock_case_size'];
            } else if($request->index) {
                $setting_stock_case_size = $this->settingModel->setting_stock_case_size;
                $update_setting_stock_case_size_data = $setting_stock_case_size[$request->index];
                $update_setting_stock_case_size_data['description'] = $request->description;
                $update_setting_stock_case_size_data['size'] = $request->size;
                $update_setting_stock_case_size_data['default'] = $request->default;
                $setting_stock_case_size[$request->index] = $update_setting_stock_case_size_data;
                $this->settingModel->setting_stock_case_size = $setting_stock_case_size;
            }
        }else{
            $this->settingModel = Setting::find($setting);
            $settingInput = $request->except('_token', '_method', 'created_at', 'updated_at');
            
            // Check condition from request to update particular index of setting_stock_group
            if ($request->setting_stock_group) {
                $this->settingModel->setting_stock_group = $settingInput['setting_stock_group'];
            } else if($request->code) {
                $setting_stock_group = $this->settingModel->setting_stock_group;
                $update_setting_stock_group_data = $setting_stock_group[$request->index];
                $update_setting_stock_group_data['code'] = $request->code;
                $update_setting_stock_group_data['name'] = $request->name;
                $setting_stock_group[$request->index] = $update_setting_stock_group_data;
                $this->settingModel->setting_stock_group = $setting_stock_group;
            }
        }
        $this->settingModel->update();
        return redirect()->back()->with('success', 'Setting Updated Successfuly');
    }

    public function Destroy(Request $request, $setting)
    {
        $currentRoute = explode('-', $setting);
        if(is_array($currentRoute)) {
            $this->settingModel = Setting::find($currentRoute[0]);
            if($request->session()->get('view') == 'case-size'){
                $setting_stock_case_size = $this->settingModel->setting_stock_case_size;
                unset($setting_stock_case_size[$currentRoute[1]]);
                $this->settingModel->setting_stock_case_size = $setting_stock_case_size;
                $this->settingModel->update();
                $request->session()->reflash();
             
                return view('menu.setting.settingCaseSize', ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
            }else{
                $setting_stock_group = $this->settingModel->setting_stock_group;
                unset($setting_stock_group[$currentRoute[1]]);
                $this->settingModel->setting_stock_group = $setting_stock_group;
                $this->settingModel->update();
                $request->session()->reflash();
             
                return view('menu.setting.settingStockGroup', ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
            }
        } else {
            Setting::destroy($setting);
        }
        
       
    }

    private function Data()
    {
        return [
            'settingModel' => $this->settingModel,
            'settingList' => $this->settingList,
        ];
    }
}
